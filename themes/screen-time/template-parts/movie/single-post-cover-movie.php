<?php
/**
 * Template part for displaying movie cover in single movie page.
 *
 * @package screen-time
 */

?>

<div class="movie-cover-container">
	<?php
	if ( have_posts() ) {
		the_post();
		if ( ! get_post_thumbnail_id() ) {
			?>
			<img class="cover-image" style="width: <?php echo esc_attr( get_theme_mod( 'single-movie-page-poster-width-setting' ) ); ?>; height: <?php echo esc_attr( get_theme_mod( 'single-movie-page-poster-height-setting' ) ); ?>;" 
			src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/placeholder.jpg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
			<?php
		} else {
			?>
			<img class="cover-image" style="width: <?php echo esc_attr( get_theme_mod( 'single-movie-page-poster-width-setting' ) ); ?>; height: <?php echo esc_attr( get_theme_mod( 'single-movie-page-poster-height-setting' ) ); ?>;"
			src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>" alt="<?php the_title(); ?>"/>
			<?php
		}

		if ( ! empty( get_theme_mod( 'site-text-separator-setting' ) ) ) {
			$separator = get_theme_mod( 'site-text-separator-setting' );
		} else {
			$separator = '•';
		}
		?>
		<div class="movie-info">
			<h1 class="movie-cover-title" ><?php the_title(); ?></h1>
			<div class="movie-meta-info">
				<span class="movie-details-item movie-rating">
					<img class="star-icon" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/star.svg' ); ?>" alt="<?php esc_attr_e( 'rating-icon', 'screen-time' ); ?>"/>
					<?php
					if ( get_post_meta( get_the_ID(), 'rt-movie-meta-basic-rating', true ) === '' ) {
						echo esc_html( '-/10' );
					} else {
						echo esc_html( round( get_post_meta( get_the_ID(), 'rt-movie-meta-basic-rating', true ), 1 ) ) . '/10';
					}
					?>
				</span>
				<span class="dot_separator">
					<?php echo esc_html( $separator ); ?>
				</span>
				<span class="movie-details-item">
					<?php
					if ( get_post_meta( get_the_ID(), 'rt-movie-meta-basic-release-date', true ) !== '' ) {
						echo esc_html( wp_date( 'Y', strtotime( get_post_meta( get_the_ID(), 'rt-movie-meta-basic-release-date', true ) ) ) );
					} else {
						echo esc_html( ' - ' );
					}
					?>
				</span>
				<span class="dot_separator">
					<?php echo esc_html( $separator ); ?>
				</span>
				<span class="movie-details-item">
					<?php
					if ( get_post_meta( get_the_ID(), 'rt-movie-meta-basic-content-rating', true ) === '' ) {
						echo esc_html( '-/10' );
					} else {
						echo esc_html( get_post_meta( get_the_ID(), 'rt-movie-meta-basic-content-rating', true ) );
					}
					?>
				</span>
				<span class="dot_separator">
					<?php echo esc_html( $separator ); ?>
				</span>
				<span class="movie-details-item movie-library-movie-cover-runtime">
					<?php
					if ( format_human_readable_duration( get_the_ID(), 'HM' ) === '' ) {
						echo esc_html( '0' );
					} else {
						if ( ! empty( get_theme_mod( 'movie-runtime-format-setting' ) ) && 'HH:MM' === get_theme_mod( 'movie-runtime-format-setting' ) ) {
							echo esc_html( format_human_readable_duration( get_the_ID(), 'HM' ) );
						} else {
							echo esc_html( get_post_meta( get_the_ID(), 'rt-movie-meta-basic-runtime', true ) . ' Minutes' );
						}
					}
					?>
				</span>
			</div>
			<div class="movie-cover-excerpt">
				<?php the_excerpt(); ?>
			</div>
			<ul class="movie-container-genre">
				<?php
				$term_names = get_the_terms( get_the_ID(), 'rt-movie-genre' );
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
			<div class="movie-director">
				<span class="movie-director-label"><?php esc_html_e( 'Director', 'screen-time' ); ?>: </span>
				<ul class="movie-director-list">
					<?php
					$directors = get_post_meta( get_the_ID(), 'rt-movie-meta-crew-director', true );

					$directors = json_decode( $directors );

					if ( ! $directors ) {
						$directors = array();
					}

					foreach ( $directors as $director ) :
						?>
						<li class="movie-director-item">
							<a href="<?php echo esc_url( get_permalink( $director ) ); ?>"><?php echo esc_html( get_the_title( $director ) ); ?></a>
						</li>
						<?php
					endforeach;
					?>
				</ul>
			</div>
		</div>
		<?php
	}
	?>
</div>