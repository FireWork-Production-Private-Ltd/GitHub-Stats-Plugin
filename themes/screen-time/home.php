<?php
/**
 * Home callback file
 *
 * @package screen-time
 */

get_header();
?>

<div class="movie-slider-main">
	<div class="movie-slider-container" >
		<div class="movie-slides">
			<?php
			$args = array(
				'post_type'      => 'rt-movie',
				'posts_per_page' => 4,
				'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- Reason: it's a custom query.
					array(
						'taxonomy' => 'rt-movie-label',
						'field'    => 'slug',
						'terms'    => 'slider',
					),
				),
			);

			$movies = get_posts( $args ); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.get_posts_get_posts -- Reason: it's a custom query.

			if ( ! is_array( $movies ) ) {
				$movies = array();
			}

			foreach ( $movies as $movie ) :
				?>
				<div style='background-image: url("<?php echo esc_url( wp_get_attachment_url( str_replace( array( '[', ']' ), '', get_post_meta( $movie->ID, 'rt-movie-meta-carousel-poster', true ) ) ) ); ?>")' class="slide">
					<div class="slide-container">
						<div class="slide-content">
							<h2 class="movie-container-title"><?php echo esc_html( $movie->post_title ); ?></h2>
							<div class="movie-container-description">
								<?php echo wp_kses_post( get_the_excerpt( $movie->ID ) ); ?>
							</div>
							<div class="movie-container-info">
								<div class="container-info-item"><?php echo esc_html( wp_date( 'Y', strtotime( get_post_meta( $movie->ID, 'rt-movie-meta-basic-release-date', true ) ) ) ); ?></div>
								<div class="dots">•</div>
								<div class="container-info-item"><?php echo esc_html( 'PG-13' ); ?></div>
								<div class="dots">•</div>
								<div class="container-info-item">
									<?php
										echo esc_html( format_human_readable_duration( $movie->ID, 'HM' ) );
									?>
								</div>
							</div>
							<ul class="movie-container-genre">
								<?php
								$term_names = get_the_terms( $movie->ID, 'rt-movie-genre' );
								if ( ! empty( $term_names ) && ! is_wp_error( $term_names ) ) :
									foreach ( $term_names as $term_name ) :
										// create the archive page link of term.
										$term_link = get_term_link( $term_name, 'rt-movie-genre' );

										if ( ! $term_link || is_wp_error( $term_link ) ) {
											continue;
										}

										?>
										<li class="movie-container-genre-item hover-btn">
											<a href="<?php echo esc_url( $term_link ); ?>"><?php echo esc_html( $term_name->name ); ?></a>
										</li>
										<?php
									endforeach;
								endif;
								?>
							</ul>
						</div>
					</div>
				</div>
				<?php
			endforeach;
			?>
		</div>
	</div>
	<div class="slide-dots-container">
		<?php
		$total_movies = count( $movies );
		for ( $i = 0; $i < $total_movies; $i++ ) :
			?>
			<div class="slide-dot"></div>
			<?php
		endfor;
		?>
	</div>
</div>
<?php

get_template_part( 'template-parts/post/upcoming-movies' );
get_template_part( 'template-parts/post/trending-movies' );

get_footer();
