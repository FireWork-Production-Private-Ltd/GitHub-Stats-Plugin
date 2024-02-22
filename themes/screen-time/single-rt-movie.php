<?php
/**
 * Single page Template file
 *
 * @package screen-time
 */

get_header();

get_template_part( 'template-parts/movie/single-post-cover', 'movie' );

get_template_part(
	'template-parts/synopsis',
	'container',
	array( 'title' => 'Synopsis' )
);
get_template_part( 'template-parts/movie/movie', 'crew' );
get_template_part( 'template-parts/snapshot', 'gallery' );

get_template_part(
	'template-parts/videos-gallery',
	'',
	array(
		'title' => 'Trailer & Clips',
	)
);

?>

<div id="reviews" class="custom-container movie-review">
	<div class="section-title-wrap">
		<div class="container-heading">
			<div class="container-heading-line"></div>
			<h1 class="container-heading-title"><?php esc_html_e( 'Reviews', 'screen-time' ); ?></h1>
		</div>
	</div>
	<ul class="review-list">
	<?php

	$reviews = get_comments(
		array(
			'post_id' => get_the_ID(),
			'number'  => 4,
		)
	);

	if ( ! is_array( $reviews ) ) {
		$reviews = array();
	}

	foreach ( $reviews as $review ) {
		?>
		<li class="review-item">
			<div class="review-header">
				<a href="<?php echo esc_url( get_comment_author_url( $review->comment_ID ) ); ?>" >
					<img class="review-avatar" src="<?php echo esc_url( get_avatar_url( $review->comment_author_email ) ); ?>" alt="<?php esc_attr_e( 'Avatar', 'screen-time' ); ?>">
				</a>
				<a href="<?php echo esc_url( get_comment_author_url( $review->comment_ID ) ); ?>" >
					<div class="review-author-name"><?php echo esc_html( $review->comment_author ); ?></div>
				</a>
			</div>
			<div class="review-content">
				<?php echo esc_html( $review->comment_content ); ?>
			</div>
			<div class="review-publish-date">
				<?php
					echo wp_kses( wp_date( 'j M Y', strtotime( $review->comment_date ) ), 'screen-time' );
				?>
			</div>
		</li>
		<?php
	}
	?>
	</ul>
</div>

<?php
comments_template();
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

if ( is_active_sidebar( 'rt-movie-sidebar' ) ) {
	dynamic_sidebar( 'rt-movie-sidebar' );
}

get_footer();