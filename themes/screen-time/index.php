<?php
/**
 * Index callback file
 *
 * @package screen-time
 */

get_header();
?>

<div class="custom-container">
	<div class="default-container">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
				<div class="container-item">
					<a href="<?php the_permalink(); ?>">
				<?php
					the_title( '<h2 class="container-title">', '</h2>' );
				?>
					</a>
					<div class="container-content">
						<?php
						the_content();
						?>
					</div>
				</div>
				<?php
			endwhile;
		else :
			esc_html_e( 'No posts matched your criteria.', 'screen-time' );
		endif;
		?>
	</div>
</div>

<?php

get_footer();
