<?php
/**
 * Header Navigation Template
 *
 * @package screen-time
 */

?>

<div class="desktop-top-menu">
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'primary-menu',
			'container'      => 'nav',
			'menu_class'     => 'primary-nav-menu',
		)
	);
	?>
</div>