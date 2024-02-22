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
				// Check if person post id is not empty.
				if ( 0 !== (int) $attributes['personPostID'] ) {
					$args = array(
						'post_type' => 'rt-person',
						'p'         => (int) $attributes['personPostID'],
					);

					// Custom Query.
					$movie = new WP_Query( $args ); //phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.get_posts_get_posts -- Reason: used the get_posts function because we have to filter data.

					// Check if movie is not empty then show movie.
					if ( $movie->have_posts() ) {
						$movie->the_post();
						?>
						<div class="custom-block-card-item">
								<a target="_blank" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>">
									<?php
									// Check if person image is not empty then show image.
									get_the_post_thumbnail_url( get_the_ID() ) ?
									$poster_url = get_the_post_thumbnail_url( get_the_ID() ) :
									$poster_url = RT_MOVIE_URL . '/assets/images/default-placeholder.png';
									?>
									<img class="custom-block-card-image" src="<?php echo esc_url( $poster_url ); ?>" alt="<?php esc_attr_e( 'Peron Image', 'movie-library' ); ?>" />
								</a>
								<a target="_blank" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>">
									<div class="custom-block-card-detail">
										<h4 class="custom-block-card-title">
											<?php
												// Check if person title is not empty then show title.
												( get_the_title() ) ? the_title() : esc_html_e( '(No Title)', 'movie-library' );
											?>
										</h4>
										<p class="custom-block-card-info">
											<span><?php esc_html_e( 'Career: ', 'movie-library' ); ?></span>
											<?php
												// Check if person career is not empty then show career.
												$movie_genre = get_the_term_list( get_the_ID(), 'rt-person-career', '', ', ', '' );
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