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


if ( ! function_exists( 'get_meta_data_from_meta_table' ) ) {
	/**
	 * Method get_meta_data_from_meta_table for collect meta data from meta table
	 *
	 * @param $id       $id post id.
	 * @param $meta_key $meta_key meta key name.
	 * @param $name     $name name of category.
	 *
	 * @return void
	 */
	function get_meta_data_from_meta_table( $id, $meta_key, $name ) {
		$data = json_decode( get_post_meta( $id, $meta_key, true ) );

		// Check if data is empty.
		if ( ! $data ) {
			echo esc_html( "No {$name} Found" );
		} else {
			// check if name is Actor then show only 2 actor.
			if ( 'Actor' === $name ) {
				$data = array_slice( $data, 0, 2 );
			}
			$data_name = array();

			// Get the title and create array.
			foreach ( $data as $item ) {
				$data_name[] = get_the_title( $item );
			}

			echo esc_html( implode( ', ', $data_name ) );
		}
	}
}

if ( ! function_exists( 'get_movie_release_date' ) ) {
	/**
	 * Method get_movie_release_date
	 *
	 * @param $id $id movie id.
	 *
	 * @return string
	 */
	function get_movie_release_date( $id ) {
		return wp_date( 'd M Y', strtotime( get_post_meta( $id, 'rt-movie-meta-basic-release-date', true ) ) );
	}
}
?>

<div class="custom-block-main">
	<div class="custom-block-container">
		<div class="custom-block-card">
			<div class="custom-block-card-container">
				<?php
				// Check if Movie Post ID is not empty.
				if ( 0 !== (int) $attributes['moviePostID'] ) {
					$args  = array(
						'post_type' => 'rt-movie',
						'p'         => (int) $attributes['moviePostID'],
					);
					$movie = new WP_Query( $args ); //phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.get_posts_get_posts -- Reason: used the get_posts function because we have to filter data.

					// Check if movie is not empty then show movie.
					if ( $movie->have_posts() ) {
						$movie->the_post();
						?>
						<div class="custom-block-card-item">
							<a target="_blank" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>">
								<?php
								// Check if movie poster is not empty then show movie poster.
								get_the_post_thumbnail_url( get_the_ID() ) ?
								$poster_url = get_the_post_thumbnail_url( get_the_ID() ) :
								$poster_url = RT_MOVIE_URL . '/assets/images/default-placeholder.png';
								?>
								<img class="custom-block-card-image" src="<?php echo esc_url( $poster_url ); ?>" alt="<?php esc_attr_e( 'Movie Image', 'movie-library' ); ?>" />
							</a>
							<a target="_blank" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>">
								<div class="custom-block-card-detail">
									<h4 class="custom-block-card-title">
										<?php
											// Check if movie title is not empty then show movie title.
											( get_the_title() ) ? the_title() : esc_html_e( '(No Title)', 'movie-library' );
										?>
									</h4>
									<p class="custom-block-card-info">
										<span><?php esc_html_e( 'Genre: ', 'movie-library' ); ?></span>
										<?php
											// Check if movie genre is not empty then show movie genre.
											$movie_genre = get_the_term_list( get_the_ID(), 'rt-movie-genre', '', ', ', '' );
											echo wp_kses( ( $movie_genre ) ? $movie_genre : esc_html__( '(No Genre)', 'movie-library' ), array() );
										?>
									</p>
									<p class="custom-block-card-info">
										<span><?php esc_html_e( 'Release: ', 'movie-library' ); ?></span>
										<?php
											// Check if movie release date is not empty then show movie release date.
											$release_date = get_movie_release_date( get_the_ID() );
											echo esc_html( ( $release_date ) ? $release_date : esc_html__( '(No Release Date)', 'movie-library' ) );
										?>
									</p>
									<p class="custom-block-card-info">
										<span><?php esc_html_e( 'Director: ', 'movie-library' ); ?></span>
										<?php
											// Check if movie director is not empty then show movie director.
											get_meta_data_from_meta_table( get_the_ID(), 'rt-movie-meta-crew-director', 'Director' );
										?>
									</p>
									<p class="custom-block-card-info">
										<span><?php esc_html_e( 'Actor: ', 'movie-library' ); ?></span>
										<?php
											// Check if movie actor is not empty then show movie actor.
											get_meta_data_from_meta_table( get_the_ID(), 'rt-movie-meta-crew-actor', 'Actor' );
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
						esc_html_e( 'No Movie Found', 'movie-library' );
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