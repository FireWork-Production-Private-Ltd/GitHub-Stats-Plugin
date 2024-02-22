<?php
/**
 * Template part for displaying person cover in single person page.
 *
 * @package screen-time
 */

?>

<div class="person-cover-container">
	<?php
	if ( have_posts() ) {
		the_post();
		if ( ! get_post_thumbnail_id() ) {
			?>
			<img class="cover-image" style="width: <?php echo esc_attr( get_theme_mod( 'single-person-page-poster-width-setting' ) ); ?>; height: <?php echo esc_attr( get_theme_mod( 'single-person-page-poster-height-setting' ) ); ?>;"
			src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/placeholder.jpg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
			<?php
		} else {
			?>
			<img class="cover-image" style="width: <?php echo esc_attr( get_theme_mod( 'single-person-page-poster-width-setting' ) ); ?>; height: <?php echo esc_attr( get_theme_mod( 'single-person-page-poster-height-setting' ) ); ?>;"
			src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>" alt="<?php the_title(); ?>"/>
			<?php
		}
		?>
		<!-- <img class="cover-image" src="<?php the_post_thumbnail_url(); ?>"/> -->	
		<div class="person-info">
			<h1 class="person-cover-title" ><?php the_title(); ?></h1>
			<div class="person-meta-info">
				<!-- <span class="person-details-item person-birthday">
					<?php esc_html_e( 'Occupation:', 'screen-time' ); ?>
				</span> -->
				<span class="person-occupation">
					<?php echo wp_kses( get_the_term_list( get_the_ID(), 'rt-person-career', '', ', ', '' ), array() ); ?>
				</span>
			</div>
			<div class="person-meta-info">
				<span class="person-details-item person-birthday">
					<?php esc_html_e( 'Born:', 'screen-time' ); ?>
				</span>
				<span class="person-dob">
					<?php
					echo wp_kses( wp_date( 'd F Y', strtotime( get_post_meta( get_the_ID(), 'rt-person-meta-basic-birth-date', true ) ) ), 'screen-time' );

					$age = wp_date( 'Y' ) - wp_date( 'Y', strtotime( get_post_meta( get_the_ID(), 'rt-person-meta-basic-birth-date', true ) ) );
					printf( esc_html( ' (age %d years)' ), (int) $age );
					?>
				</span>
			</div>
			<div class="person-meta-info">
				<span class="person-details-item person-birthday">
					<?php esc_html_e( 'Birthplace:', 'screen-time' ); ?>
				</span>
				<span class="person-dob-place">
					<?php
					echo esc_html( get_post_meta( get_the_ID(), 'rt-person-meta-basic-birth-place', true ) );
					?>
				</span>
			</div>
			<div class="person-meta-info social-media">
				<span class="person-details-item person-birthday">
					<?php esc_html_e( 'Socials:', 'screen-time' ); ?>
				</span>
				<span class="person-social">
					<?php
					if ( get_post_meta( get_the_ID(), 'rt-person-meta-social-instagram', true ) ) {
						?>
						<a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'rt-person-meta-social-instagram', true ) ); ?>">
							<img class="icon-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/instagram-frame.svg' ); ?>" alt="<?php esc_attr_e( 'instagram-icon', 'screen-time' ); ?>"/>
						</a>
						<?php
					}
					if ( get_post_meta( get_the_ID(), 'rt-person-meta-social-twitter', true ) ) {
						?>
						<a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'rt-person-meta-social-twitter', true ) ); ?>">
							<img class="icon-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/twitter-frame.svg' ); ?>" alt="<?php esc_attr_e( 'twitter-icon', 'screen-time' ); ?>"/>
						</a>
						<?php
					}
					if ( get_post_meta( get_the_ID(), 'rt-person-meta-social-facebook', true ) ) {
						?>
						<a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'rt-person-meta-social-facebook', true ) ); ?>">
							<img class="icon-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/facebook-frame.svg' ); ?>" alt="<?php esc_attr_e( 'facebook-icon', 'screen-time' ); ?>"/>
						</a>
						<?php
					}
					if ( get_post_meta( get_the_ID(), 'rt-person-meta-social-web', true ) ) {
						?>
						<a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'rt-person-meta-social-web', true ) ); ?>">
							<img class="icon-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/web-frame.svg' ); ?>" alt="<?php esc_attr_e( 'web-icon', 'screen-time' ); ?>"/>
						</a>
						<?php
					}
					?>
				</span>
			</div>
		</div>
		<?php
	}
	?>
</div>