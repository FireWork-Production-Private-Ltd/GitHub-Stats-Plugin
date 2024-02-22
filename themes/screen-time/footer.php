<?php
/**
 * Footer of theme
 * Contains the closing of the div and all content after.
 * Contains menu and logo.
 *
 * @package screen-time
 */

?>

	</div>
</div>

<footer class="footer-div">
	<div class="footer-container">
		<div class="footer-container-info">
			<div class="footer-left-part">
				<h2 class="logo" >
					<?php the_custom_logo(); ?>
				</h2>
				<h4 class="footer-social-title" ><?php esc_html_e( 'Follow Us', 'screen-time' ); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'social-menu',
						'container'      => 'ul',
						'menu_class'     => 'footer-social',
						'walker'         => new Walker_Social_Menu(),
					)
				);
				?>
			</div>
			<div class="footer-menu">
				<h3 class="footer-menu-title"><?php esc_html_e( 'Company', 'screen-time' ); ?></h3>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'company-menu',
						'container'      => 'nav',
						'menu_class'     => 'footer-menu',
					)
				);
				?>
			</div>
			<div class="footer-menu">
				<h3 class="footer-menu-title"><?php esc_html_e( 'Explore', 'screen-time' ); ?></h3>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-menu',
						'container'      => 'nav',
						'menu_class'     => 'footer-menu',
					)
				);
				?>
			</div>
		</div>
		<hr class="footer-line" />
		<p class="footer-copyright-text" >&#169;
			<?php
			/* translators: %s: current year. */
			printf( esc_html__( '%1$u %2$s. All Rights Reserved.', 'screen-time' ), esc_html( date_i18n( 'Y' ) ), esc_html( get_bloginfo( 'name' ) ) );
			?>
			<a class="footer-service-policy" href="#"><?php esc_html_e( 'Terms of Service', 'screen-time' ); ?></a>
			|
			<a class="footer-service-policy" href="#"><?php esc_html_e( 'Privacy Policy', 'screen-time' ); ?></a>
		</p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>