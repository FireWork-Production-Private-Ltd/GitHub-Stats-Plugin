<?php

function github_get_login_url() {
	$options      = get_option( 'github_stats_settings' );
	$client_id    = $options['github_client_id'];
	$redirect_uri = urlencode( home_url( '/github-callback/' ) );
	$state        = wp_generate_uuid4();
	set_transient( 'github_oauth_state', $state, 3600 );

	return "https://github.com/login/oauth/authorize?client_id={$client_id}&redirect_uri={$redirect_uri}&state={$state}&scope=repo";
}

function github_get_access_token( $code ) {
	$options       = get_option( 'github_stats_settings' );
	$client_id     = $options['github_client_id'];
	$client_secret = $options['github_client_secret'];
	$redirect_uri  = home_url( '/github-callback/' );
	$url           = 'https://github.com/login/oauth/access_token';

	$response = wp_remote_post(
		$url,
		array(
			'body'    => array(
				'client_id'     => $client_id,
				'client_secret' => $client_secret,
				'code'          => $code,
				'redirect_uri'  => $redirect_uri,
			),
			'headers' => array(
				'Accept' => 'application/json',
			),
		)
	);

	if ( is_wp_error( $response ) ) {
		return false;
	}

	$body = json_decode( wp_remote_retrieve_body( $response ), true );
	return $body['access_token'] ?? false;
}

function github_get_user_profile( $access_token ) {
	$response = wp_remote_get(
		'https://api.github.com/user',
		array(
			'headers' => array(
				'Authorization' => 'token ' . $access_token,
				'User-Agent'    => 'WordPress-GitHub-Plugin',
			),
		)
	);

	if ( is_wp_error( $response ) ) {
		return false;
	}

	$body = json_decode( wp_remote_retrieve_body( $response ), true );
	return $body;
}

function github_get_user_stats( $access_token ) {
	$query = <<<'GRAPHQL'
    query {
      viewer {
        contributionsCollection {
          totalCommitContributions
          restrictedContributionsCount
          totalPullRequestContributions
          totalIssueContributions
          contributionCalendar {
            totalContributions
            weeks {
              contributionDays {
                contributionCount
                date
              }
            }
          }
        }
        repositories {
          totalCount
        }
        followers {
          totalCount
        }
        following {
          totalCount
        }
        starredRepositories {
          totalCount
        }
      }
    }
    GRAPHQL;

	$response = wp_remote_post(
		'https://api.github.com/graphql',
		array(
			'body'    => json_encode( array( 'query' => $query ) ),
			'headers' => array(
				'Authorization' => 'Bearer ' . $access_token,
				'Content-Type'  => 'application/json',
			),
		)
	);

	if ( is_wp_error( $response ) ) {
		return false;
	}

	$body = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( ! isset( $body['data']['viewer'] ) ) {
		return false;
	}
	$data          = $body['data']['viewer'];
	$contributions = $data['contributionsCollection']['contributionCalendar']['weeks'];

	// Calculate active streaks
	$current_streak             = 0;
	$max_streak                 = 0;
	$current_year_contributions = 0;
	$last_year_contributions    = 0;
	$total_contributions        = 0;
	$today                      = new DateTime();
	$current_year               = $today->format( 'Y' );
	$last_year                  = $today->modify( '-1 year' )->format( 'Y' );

	foreach ( $contributions as $week ) {
		foreach ( $week['contributionDays'] as $day ) {
			$date               = new DateTime( $day['date'] );
			$year               = $date->format( 'Y' );
			$contribution_count = $day['contributionCount'];

			if ( $contribution_count > 0 ) {
				++$current_streak;
				$total_contributions += $contribution_count;

				if ( $year == $current_year ) {
					$current_year_contributions += $contribution_count;
				} elseif ( $year == $last_year ) {
					$last_year_contributions += $contribution_count;
				}
			} else {
				if ( $current_streak > $max_streak ) {
					$max_streak = $current_streak;
				}
				$current_streak = 0;
			}
		}
	}

	if ( $current_streak > $max_streak ) {
		$max_streak = $current_streak;
	}

	return array(
		'total_stars'                => $data['starredRepositories']['totalCount'],
		'total_commits'              => $data['contributionsCollection']['totalCommitContributions'],
		'total_prs'                  => $data['contributionsCollection']['totalPullRequestContributions'],
		'total_issues'               => $data['contributionsCollection']['totalIssueContributions'],
		'last_year_contributions'    => $last_year_contributions,
		'current_year_contributions' => $current_year_contributions,
		'total_contributions'        => $total_contributions,
		'current_streak'             => $current_streak,
		'max_streak'                 => $max_streak,
		'followers'                  => $data['followers']['totalCount'],
		'following'                  => $data['following']['totalCount'],
	);
}
