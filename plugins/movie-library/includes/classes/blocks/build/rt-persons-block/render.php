<?php
/**
 * Render the block.
 *
 * @package movie-library
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $attributes ) ) {
	exit;
}
?>

<div class="custom-block-main">
	<div class="custom-block-container">
		<div class="custom-block-card">
			<div class="custom-block-card-container">
				<?php
				$args = array(
					'post_type'      => 'rt-person',
					'posts_per_page' => $attributes['numberOfPersons'],
				);

				// Custom Query args.
				if ( ! empty( $attributes['personCareer'] ) ) {
					$args['tax_query'][] = //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- Reason: Added Custom filter based on genre.
					array(
						'taxonomy' => 'rt-person-career',
						'field'    => 'term_id',
						'terms'    => (int) $attributes['personCareer'],
					);
				}

				// Custom Query.
				$persons = get_posts( $args ); //phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.get_posts_get_posts -- Reason: used the get_posts function because we have to filter data.

				// Check if person is not empty then show person.
				if ( ! empty( $persons ) ) {

					// Loop through the person.
					foreach ( $persons as $person ) {
						?>
						<div class="custom-block-card-item">
							<a target="_blank" href="<?php echo esc_url( get_permalink( $person->ID ) ); ?>">
								<?php

								// Check if person image is not empty then show image.
								get_the_post_thumbnail_url( $person->ID ) ?
								$poster_url = get_the_post_thumbnail_url( $person->ID ) :
								$poster_url = RT_MOVIE_URL . '/assets/images/default-placeholder.png';
								?>
								<img class="custom-block-card-image" src="<?php echo esc_url( $poster_url ); ?>" alt="<?php esc_attr_e( 'Peron Image', 'movie-library' ); ?>" />
							</a>
							<a target="_blank" href="<?php echo esc_url( get_permalink( $person->ID ) ); ?>">
								<div class="custom-block-card-detail">
									<h4 class="custom-block-card-title">
										<?php
											// Check if person title is not empty then show title.
											echo ( $person->post_title ) ? esc_html( $person->post_title ) : esc_html__( '(No Title)', 'movie-library' );
										?>
									</h4>
									<p class="custom-block-card-info">
										<span><?php esc_html_e( 'Career: ', 'movie-library' ); ?></span>
										<?php
											// Check if person career is not empty then show career.
											$movie_genre = get_the_term_list( $person->ID, 'rt-person-career', '', ', ', '' );
											echo wp_kses( ( $movie_genre ) ? $movie_genre : esc_html__( '(No Career Found)', 'movie-library' ), array() );
										?>
									</p>
								</div>
							</a>
						</div>
						<?php
					}
				} else {
					?>
				<div class="no-movie-found">
					<h2 class="no-movie-found-title">			
						<?php
						esc_html_e( 'No Person Found', 'movie-library' );
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