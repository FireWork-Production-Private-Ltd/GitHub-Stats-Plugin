<?php
/**
 * The header for our theme
 * This file contains the opening <html> tag and all the stuff that comes before the main content
 * This file shows the header of the theme
 *
 * @package screen-time
 */

?>

<!doctype html>
<html  <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php bloginfo( 'name' ); ?></title>
	<?php wp_head(); ?>
</head>
 
<body <?php body_class(); ?> >
<?php wp_body_open(); ?>
<div id="page" class="site">
	<div class="header-main">
		<div class="header-container">

			<?php get_template_part( 'template-parts/header/responsive-header' ); ?>

			<?php get_template_part( 'template-parts/header/header-navigation' ); ?>

		</div>
	</div>
	<div class="container">