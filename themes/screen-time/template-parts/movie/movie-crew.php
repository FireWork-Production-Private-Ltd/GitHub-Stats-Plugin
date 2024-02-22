<?php
/**
 * The template for displaying movie cast and crew
 *
 * @package screen-time
 */

?>

<div id="cast-and-crew" class="movie-cast-crew custom-container">
	<div class="section-title-wrap">
		<div class="container-heading">
			<div class="container-heading-line"></div>
			<h1 class="container-heading-title"><?php esc_html_e( 'Cast & Crew', 'screen-time' ); ?></h1>
		</div>
		<?php
		$archive_link = get_post_type_archive_link( 'rt-person' );
		$archive_link = add_query_arg( 'movie-id', get_the_ID(), $archive_link );
		$archive_link = wp_nonce_url( $archive_link, 'movie_nonce', 'movie_nonce' );
		?>
		<a href="<?php echo esc_url( $archive_link ); ?>" class="view-all hidden desktop-view-all">
			<?php esc_html_e( 'View All', 'screen-time' ); ?>
			<img class="star-icon" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/red-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'Rating-icon', 'screen-time' ); ?>" />
		</a>
	</div>
	<ul class="movie-cast-crew-list">
		<?php
		$persons = get_cast_crew( get_the_ID(), 8 );

		foreach ( $persons as $person_id ) :
			?>
			<li>
				<a class="movie-cast-crew-item" href="<?php echo esc_url( get_permalink( $person_id ) ); ?>" >
					<?php
					if ( ! get_the_post_thumbnail_url( $person_id ) ) {
						?>
						<img class="movie-cast-crew-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/placeholder.jpg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
						<?php
					} else {
						?>
						<img class="movie-cast-crew-image" src="<?php echo esc_url( get_the_post_thumbnail_url( $person_id ) ); ?>" alt="<?php echo esc_attr( get_the_title( $person_id ) ); ?>">
						<?php
					}
					?>

					<div class="movie-cast-crew-name">
						<?php echo esc_html( get_the_title( $person_id ) ); ?>
					</div>
				</a>
			</li>
			<?php
		endforeach;
		?>
	</ul>
	<div class="view-all-wrapper">
		<a href="<?php echo esc_url( $archive_link ); ?>" class="view-all hidden">
			<?php esc_html_e( 'View All', 'screen-time' ); ?>
			<img class="star-icon" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/red-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'arrow-icon', 'screen-time' ); ?>" />
		</a>
	</div>
</div>