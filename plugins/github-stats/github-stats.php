<?php
/**
 * Plugin Name: Github Stats
 * Description: A plugin to display Github stats
 * Version: 1.0
 * Requires PHP: 7.0
 * Author: Utsav Patel, Renish Surani
 * Author URI: https://github.com/up1512001, https://github.com/renishsurani
 * License: GPL2
 * Keywords: github, stats
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include GitHub API file
require_once plugin_dir_path(__FILE__) . 'src/github-api.php';

// Register shortcode for displaying GitHub stats
add_shortcode('github_stats', 'display_github_stats');
add_shortcode('github_profile', 'display_github_profile');

// Add settings menu
add_action('admin_menu', 'github_stats_add_admin_menu');
add_action('admin_init', 'github_stats_settings_init');

function github_stats_add_admin_menu() {
    add_options_page('Github Stats', 'Github Stats', 'manage_options', 'github_stats', 'github_stats_options_page');
}

function github_stats_settings_init() {
    register_setting('githubStats', 'github_stats_settings');

    add_settings_section(
        'github_stats_section',
        __('Github API Settings', 'github-stats'),
        'github_stats_settings_section_callback',
        'githubStats'
    );

    add_settings_field(
        'github_client_id',
        __('Client ID', 'github-stats'),
        'github_client_id_render',
        'githubStats',
        'github_stats_section'
    );

    add_settings_field(
        'github_client_secret',
        __('Client Secret', 'github-stats'),
        'github_client_secret_render',
        'githubStats',
        'github_stats_section'
    );
}

function github_client_id_render() {
    $options = get_option('github_stats_settings');
    ?>
    <input type='text' name='github_stats_settings[github_client_id]' value='<?php echo isset($options['github_client_id']) ? $options['github_client_id'] : ''; ?>'>
    <?php
}

function github_client_secret_render() {
    $options = get_option('github_stats_settings');
    ?>
    <input type='text' name='github_stats_settings[github_client_secret]' value='<?php echo isset($options['github_client_secret']) ? $options['github_client_secret']: ''; ?>'>
    <?php
}

function github_stats_settings_section_callback() {
    echo __('Enter your GitHub API credentials here.', 'github-stats');
}

function github_stats_options_page() {
    ?>
    <form action='options.php' method='post'>
        <h2>Github Stats</h2>
        <?php
        settings_fields('githubStats');
        do_settings_sections('githubStats');
        submit_button();
        ?>
    </form>
    <?php
}

// Display GitHub stats using a shortcode
function display_github_stats() {
    if (!is_user_logged_in()) {
        return 'You need to log in to see your GitHub stats.';
    }

    $user_id = get_current_user_id();
    $access_token = get_user_meta($user_id, 'github_access_token', true);

    if (!$access_token) {
        return '<a href="' . github_get_login_url() . '">Connect your GitHub account</a>';
    }

    $stats = github_get_user_stats($access_token);
    if (!$stats) {
        return 'Failed to fetch GitHub stats. <a href="' . github_get_login_url() . '">Connect your GitHub account</a>';
    }

    ob_start();
    ?>
    <div class="github-stats">
        <h2>GitHub Stats</h2>
        <p>Total Stars: <?php echo $stats['total_stars']; ?></p>
        <p>Total Commits: <?php echo $stats['total_commits']; ?></p>
        <p>Total PRs: <?php echo $stats['total_prs']; ?></p>
        <p>Total Issues: <?php echo $stats['total_issues']; ?></p>
        <p>Last Year Contributions: <?php echo $stats['last_year_contributions']; ?></p>
        <p>Current Year Contributions: <?php echo $stats['current_year_contributions']; ?></p>
        <p>Total Contributions: <?php echo $stats['total_contributions']; ?></p>
        <p>Current Active Days Streak: <?php echo $stats['current_streak']; ?></p>
        <p>Maximum Active Days Streak: <?php echo $stats['max_streak']; ?></p>
        <p>Total Followers: <?php echo $stats['followers']; ?></p>
        <p>Total Following: <?php echo $stats['following']; ?></p>
    </div>
    <?php
    return ob_get_clean();
}

// Display GitHub profile using a shortcode
function display_github_profile() {
    if (!is_user_logged_in()) {
        return 'You need to log in to see your GitHub profile.';
    }

    $user_id = get_current_user_id();
    $access_token = get_user_meta($user_id, 'github_access_token', true);

    if (!$access_token) {
        return '<a href="' . github_get_login_url() . '">Connect your GitHub account</a>';
    }

    $profile = github_get_user_profile($access_token);
    if (!$profile) {
        return 'Failed to fetch GitHub profile. <a href="' . github_get_login_url() . '">Connect your GitHub account</a>';
    }

    ob_start();
    ?>
    <div class="github-profile">
        <?php if( isset($profile['status'] ) && $profile['status'] === '401' ){
            return 'Failed to fetch GitHub profile. <a href="' . github_get_login_url() . '">Connect your GitHub account</a>';
        } else {
            ?>    
        <?php if ($profile['avatar_url']) : ?>
            <img src="<?php echo $profile['avatar_url']; ?>" alt="Profile Picture">
        <?php endif; ?>
        <h2><?php echo $profile['name']; ?> (<?php echo $profile['login']; ?>)</h2>
        <p><?php echo $profile['bio']; ?></p>
        <p>Followers: <?php echo $profile['followers']; ?></p>
        <p>Following: <?php echo $profile['following']; ?></p>
            <?php
        }
        ?>
    </div>
    <?php
    return ob_get_clean();
}

// Handle OAuth callback
add_action('init', 'github_oauth_callback');

function github_oauth_callback() {
    if (isset($_GET['code']) && isset($_GET['state'])) {
        $code = sanitize_text_field($_GET['code']);
        $state = sanitize_text_field($_GET['state']);

        // Verify the state
        if ($state !== get_transient('github_oauth_state')) {
            return;
        }

        delete_transient('github_oauth_state');

        $token = github_get_access_token($code);
        if ($token) {
            $user_id = get_current_user_id();
            update_user_meta($user_id, 'github_access_token', $token);

            wp_redirect(home_url());
            exit;
        }
    }
}
?>
