<?php
/**
 * Upcoming Movies Template
 *
 * @package screen-time
 */

?>

<div class="upcoming-movie-main">
	<div class="upcoming-movie-container">
		<div class="container-heading">
			<div class="container-heading-line"></div>
			<h1 class="container-heading-title"><?php esc_html_e( 'Upcoming Movies', 'screen-time' ); ?></h1>
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
							'terms'    => 'upcoming',
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
										<h4 class="movie-card-genre">
											<?php
											echo esc_html( get_first_genre( $movie->ID ) );
											?>
									</h4>
									<span class="movie-card-release-date">
										<?php esc_html_e( 'Release', 'movie-library' ); ?>:
										<?php
											echo esc_html( get_formatted_release_date( $movie->ID ) );
										?>
									</span>
									<span class="movie-card-content-rating">
										<?php
											echo esc_html( get_content_rating( $movie->ID ) );
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