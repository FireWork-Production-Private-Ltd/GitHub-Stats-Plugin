<?php
/**
 * The template part for displaying movie synopsis
 *
 * @package screen-time
 */

?>
<div id="synopsis" class="synopsis-container custom-container">
	<div>
		<div class="container-heading">
			<div class="container-heading-line"></div>
			<h1 class="container-heading-title"><?php echo esc_html( $args['title'] ); ?></h1>
		</div>
		<div class="the-content">
			<?php
			the_content();
			?>
		</div>
	</div>
	<?php
	if ( 'Synopsis' === $args['title'] ) {
		?>
	<div class="sidebar" style="width: <?php echo esc_attr( get_theme_mod( 'sidebar-size-setting' ) ); ?>">
		<?php
		if ( is_active_sidebar( 'rt-movie-quick-link' ) ) {
			dynamic_sidebar( 'rt-movie-quick-link' );
		}
		?>
		<div class="sidebar-container">
			<span class="sidebar-item">
				<img class="person-card-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/sidebar-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
				<a href="#synopsis">
					<p class="sidebar-item-name"><?php esc_html_e( 'Synopsis', 'screen-time' ); ?></p>
				</a>
			</span>
			<span class="sidebar-item">
				<img class="person-card-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/sidebar-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
				<a href="#cast-and-crew">
					<p class="sidebar-item-name"><?php esc_html_e( 'Cast & Crew', 'screen-time' ); ?></p>
				</a>
			</span>
			<span class="sidebar-item">
				<img class="person-card-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/sidebar-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
				<a href="#snapshots">
					<p class="sidebar-item-name"><?php esc_html_e( 'Snapshots', 'screen-time' ); ?></p>
				</a>
			</span>
			<span class="sidebar-item">
				<img class="person-card-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/sidebar-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
				<a href="#videos">
					<p class="sidebar-item-name"><?php esc_html_e( 'Trailer & Clips', 'screen-time' ); ?></p>
				</a>
			</span>
			<span class="sidebar-item">
				<img class="person-card-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/sidebar-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
				<a href="#reviews">
					<p class="sidebar-item-name"><?php esc_html_e( 'Reviews', 'screen-time' ); ?></p>
				</a>
			</span>
		</div>
	</div>
	<?php } else { ?>
		<div class="sidebar person-sidebar" style="width: <?php echo esc_attr( get_theme_mod( 'sidebar-size-setting' ) ); ?>">
		<?php
		if ( is_active_sidebar( 'rt-movie-quick-link' ) ) {
			dynamic_sidebar( 'rt-movie-quick-link' );
		}
		?>
		<div class="sidebar-container">
			<span class="sidebar-item">
				<img class="person-card-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/sidebar-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
				<a href="#synopsis">
					<p class="sidebar-item-name"><?php esc_html_e( 'About', 'screen-time' ); ?></p>
				</a>
			</span>
			<span class="sidebar-item">
				<img class="person-card-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/sidebar-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
				<a href="#person-trending-movie">
					<p class="sidebar-item-name"><?php esc_html_e( 'Popular Movies', 'screen-time' ); ?></p>
				</a>
			</span>
			<span class="sidebar-item">
				<img class="person-card-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/sidebar-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
				<a href="#snapshots">
					<p class="sidebar-item-name"><?php esc_html_e( 'Snapshots', 'screen-time' ); ?></p>
				</a>
			</span>
			<span class="sidebar-item">
				<img class="person-card-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/sidebar-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
				<a href="#videos">
					<p class="sidebar-item-name"><?php esc_html_e( 'Videos', 'screen-time' ); ?></p>
				</a>
			</span>
		</div>
	</div>
	<?php } ?>
</div>