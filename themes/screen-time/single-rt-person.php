<?php
/**
 * Single page Template file
 *
 * @package screen-time
 */

get_header();

get_template_part( 'template-parts/person/single-post-cover', 'person' );

get_template_part(
	'template-parts/synopsis',
	'container',
	array( 'title' => 'About' )
);

// get_template_part( 'template-parts/person/trending-movies', 'person' );

get_template_part( 'template-parts/snapshot', 'gallery' );

get_template_part(
	'template-parts/videos-gallery',
	'',
	array(
		'title' => 'Videos',
	)
);
?>

<div id="reviews" class="single-page-pagination">
	<?php
	the_post_navigation(
		array(
			'prev_text' => '<div class="previous-link"><div class="single-pagination-title">' . esc_html__( '&laquo; Previous Post', 'movie-library' ) . '</div> <div class="single-pagination-link">%title</div></div>',
			'next_text' => '<div class="next-link"><div class="single-pagination-title">' . esc_html__( 'Next Post &raquo;', 'movie-library' ) . '</div> <div class="single-pagination-link">%title</div></div>',
			'class'     => 'single-post-pagination',
		)
	);
	?>
</div>

<?php
if ( is_active_sidebar( 'rt-person-sidebar' ) ) {
	dynamic_sidebar( 'rt-person-sidebar' );
}

get_footer();
