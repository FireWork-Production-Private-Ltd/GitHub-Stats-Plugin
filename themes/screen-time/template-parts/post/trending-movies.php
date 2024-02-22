<?php
/**
 * Upcoming Movies Template
 *
 * @package screen-time
 */

?>

<div class="trending-movie-main">
	<div class="trending-movie-container">
		<div class="container-heading">
			<div class="container-heading-line"></div>
			<h1 class="container-heading-title"><?php esc_html_e( 'Trending Movies', 'screen-time' ); ?></h1>
		</div>
		<div class="movie-cards">
			<div class="movie-cards-container">
				<?php

				$args = array(
					'post_type'      => 'rt-movie',
					'posts_per_page' => 6,
					'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- Reason: it's a custom query.
						array(
							'taxonomy' => 'rt-movie-label',
							'field'    => 'slug',
							'terms'    => 'trending',
						),
					),
				);

				$movies = get_posts( $args ); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.get_posts_get_posts -- Reason: it's a custom query.

				if ( ! empty( $movies ) ) {
					foreach ( $movies as $movie ) :
						?>
						<div class="movie-card-item">
							<a href="<?php echo esc_url( get_permalink( $movie->ID ) ); ?>">
								<img class="movie-card-image" src="<?php echo esc_url( get_the_post_thumbnail_url( $movie->ID ) ); ?>" alt="<?php esc_attr_e( 'Movie Image', 'movie-library' ); ?>" />
							</a>
							<a href="<?php echo esc_url( get_permalink( $movie->ID ) ); ?>">
								<div class="movie-card-detail">
									<h4 class="movie-card-title">
										<?php
											echo esc_html( $movie->post_title );
										?>
									</h4>
									<h4 class="movie-card-runtime">
										<?php
										echo esc_html( format_human_readable_duration( $movie->ID ) );
										?>
									</h4>
									<span class="movie-card-release-date">
										<?php
										echo esc_html( get_movie_card_genre( $movie->ID ) );
										?>
									</span>
									<span class="movie-card-content-rating">
										<?php
										echo esc_html( wp_date( 'Y', strtotime( get_post_meta( $movie->ID, 'rt-movie-meta-basic-release-date', true ) ) ) );
										?>
									</span>
								</div>
							</a>
						</div>
						<?php
					endforeach;
				} else {
					?>
					<div class="no-movie-found">
						<h2 class="no-movie-found-title">			
							<?php
							esc_html_e( 'No Movies Found', 'movie-library' );
							?>
						</h2>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>