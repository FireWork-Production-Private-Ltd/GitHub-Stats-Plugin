<?php
/**
 * 404 callback file
 *
 * @package screen-time
 */

get_header();
?>

<div class="custom-container">
	<div class="error-container">
		<h1><?php esc_html_e( '404', 'screen-time' ); ?></h1>
		<p><?php esc_html_e( 'Page Not Found', 'screen-time' ); ?></p>
		<p><?php esc_html_e( 'Sorry, but the page you are looking for might be in another castle.', 'screen-time' ); ?></p>
		<a href="/">
			<button class="hover-btn">
				<?php esc_html_e( 'Go back to the home page', 'screen-time' ); ?>
			</button>
		</a>
	</div>
</div>

<?php

get_footer();
