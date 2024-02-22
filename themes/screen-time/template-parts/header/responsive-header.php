<?php
/**
 * Desktop header file
 *
 * @package screen-time
 */

?>
			
<header class="desktop-header" >
	<div id="search-form" class="header-search" >
		<span class="header-search-container">
			<img id="search-button" class="header-icon" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/search.svg' ); ?>" alt="<?php esc_attr_e( 'search-icon', 'screen-time' ); ?>">
			<div id="search-title">
				<?php
				esc_html_e( 'Search', 'screen-time' );
				?>
			</div>
			<?php get_search_form(); ?>
		</span>
	</div>
	<?php the_custom_logo(); ?>
	<div class="header-auth">
		<span class="header-auth-container" >
			<a href="/login">
				<img class="header-icon" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/user.svg' ); ?>" alt="<?php esc_attr_e( 'user-icon', 'screen-time' ); ?>">
				<?php
				?>
				<?php
				if ( is_user_logged_in() ) {
					global $current_user;
					echo $current_user->display_name;
				} else {
					echo 'Sign In';
				}
				?>
			</a>
		</span>
		<div class="header-lan-dropdown">
			<span class="header-lan" >
				<select name="header-language">
					<option class="lan-item" value="<?php echo esc_attr( 'ENG' ); ?>" selected><?php echo esc_html( 'ENG' ); ?></option>
					<option class="lan-item" value="<?php echo esc_attr( 'GUJ' ); ?>"><?php echo esc_html( 'GUJ' ); ?></option>
					<option class="lan-item" value="<?php echo esc_attr( 'HID' ); ?>"><?php echo esc_html( 'HID' ); ?></option>
				</select>
			</span>
		</div>
	</div>
</header>

<header class="mobile-header" >
	<div class="mobile-header-container">
		<div class="mobile-header-btn" >
			<div id="search-button1" class="header-search-container">
				<img class="header-mobile_icon" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/search.svg' ); ?>" alt="<?php esc_attr_e( 'search-icon', 'screen-time' ); ?>">
			</div>
			<div class="search-field"> 
				<?php get_search_form(); ?>
			</div>
		</div>
		<?php the_custom_logo(); ?>
		<span id="mobile-menu-icon" class="mobile-menu-icon">
			<img id="bar-icon" class="header-mobile_icon" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bar-icon.svg' ); ?>" alt="<?php esc_attr_e( 'bar-icon', 'screen-time' ); ?>">
			<img id="close-icon" class="header-mobile_icon hide" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/close-icon.svg' ); ?>" alt="<?php esc_attr_e( 'close-icon', 'screen-time' ); ?>">
		</span>
	</div>
</header>

<div id="mobile-menu" class="mobile-header-menu none">
	<div class="mobile-header-buttons">
		<button class="header-sign-in-btn">
			<a href="/login">
				<img class="header-icon" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/user.svg' ); ?>" alt="<?php esc_attr_e( 'user-icon', 'screen-time' ); ?>">
				<?php
				?>
				<?php
				if ( is_user_logged_in() ) {
					global $current_user;
					echo $current_user->display_name;
				} else {
					echo 'Sign In';
				}
				?>
			</a>
		</button>
	</div>
	<hr class="mobile-menu-line" />
	<div class="explore-menu sub-menu">
		<h1 class="menu-container">
			<span class="mobile-menu-title">
				<?php esc_html_e( 'Explore', 'screen-time' ); ?>
			</span>
			<img class="mobile-menu-icon drop-down-btn" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/down-icon.svg' ); ?>" alt="<?php esc_attr_e( 'down-icon', 'screen-time' ); ?>">
		</h1>
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'primary-menu',
				'container'       => 'nav',
				'container_class' => 'menu menu-closed',
				'menu_class'      => 'mobile-sub-menu',
			)
		);
		?>
	</div>
	<hr class="mobile-menu-line" />
	<div class="settings-menu sub-menu">
		<h1 class="menu-container">
			<span class="mobile-menu-title">
				<?php esc_html_e( 'Settings', 'screen-time' ); ?>
			</span>
			<img class="mobile-menu-icon drop-down-btn" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/down-icon.svg' ); ?>" alt="<?php esc_attr_e( 'down-icon', 'screen-time' ); ?>">
		</h1>
		<nav class="menu menu-closed">
			<ul class="mobile-sub-menu">
				<li class="menu-item">
					<a href="#">
						<?php esc_html_e( 'Language:', 'screen-time' ); ?>
						<span class="menu-lan-select">
							<?php esc_html_e( 'ENG', 'screen-time' ); ?>
							<img class="header-lan-submenu" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/triangle.svg' ); ?>" alt="<?php esc_attr_e( 'triangle-icon', 'screen-time' ); ?>">
						</span>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>