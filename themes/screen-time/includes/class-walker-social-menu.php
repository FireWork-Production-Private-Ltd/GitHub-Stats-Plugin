<?php
/**
 * Custom Walker Class for Social Icons in Menu (Footer).
 *
 * @package screen-time
 */

/**
 *  Class Screen_Time_Social_Icons_Walker for override the default menu.
 */
class Walker_Social_Menu extends Walker_Nav_Menu {

	/**
	 * Override start_el method for custom social menu.
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param object $data_object The data object.
	 * @param int    $depth Depth of menu items.
	 * @param array  $args Additional Arguments.
	 * @param int    $current_object_id Current Menu id.
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0 ): void {

		// Get the Menu title and link of the menu item.
		$menu_title = $data_object->title;
		$menu_title = strtolower( $menu_title );

		// Get the Menu Url of the menu item.
		$menu_link = $data_object->url;

		// Check if the link or menu_title contains specific social platform keywords.
		if ( 'twitter' === $menu_title ) {
			$menu_item = 'twitter';
		} elseif ( 'facebook' === $menu_title ) {
			$menu_item = 'facebook';
		} elseif ( 'instagram' === $menu_title ) {
			$menu_item = 'instagram';
		} elseif ( 'youtube' === $menu_title ) {
			$menu_item = 'youtube';
		} elseif ( 'rss' === $menu_title ) {
			$menu_item = 'rss';
		} else {
			$menu_item = '';
		}

		// If a social platform is identified, set the image URL accordingly.
		if ( '' !== $menu_item ) {
			$svg_icon = SCREEN_TIME_DIR . '/assets/images/' . $menu_item . '.svg';
		}

		// Output the menu item with the image.
		ob_start();
		?>
		<li class="social-item">
			<?php
			// If image URL exists, create the anchor tag with the image.
			if ( '' !== $svg_icon ) {
				?>
					<a href="<?php echo esc_url( ( 'rss' === $menu_title ) ? get_feed_link( 'rss2' ) : $menu_link ); ?>">
						<img class="social-icon" src="<?php echo esc_url( $svg_icon ); ?>" alt="<?php echo esc_attr( $menu_item ); ?>">
					</a>
				<?php
			}
			?>
		</li>
		<?php
		$output .= ob_get_clean();
	}
}
