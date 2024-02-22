<?php
/**
 * The template for displaying snapshots
 *
 * @package screen-time
 */

?>
<div id="snapshots" class="movie-snapshot custom-container">
	<div class="section-title-wrap">
		<div class="container-heading">
			<div class="container-heading-line"></div>
			<h1 class="container-heading-title"><?php esc_html_e( 'Snapshots', 'screen-time' ); ?></h1>
		</div>
	</div>
	<ul class="movie-snapshot-list">
		<?php
		$imgs = get_post_meta( get_the_ID(), 'rt-media-meta-img', true );
		$imgs = json_decode( $imgs );

		if ( ! is_array( $imgs ) ) {
			$imgs = array();
		}

		foreach ( $imgs as $img ) {
			?>
			<li class="movie-snapshot-item">
				<img class="movie-snapshot-image" src="<?php echo esc_url( wp_get_attachment_image_url( $img, 'full' ) ); ?>" alt="<?php echo esc_attr( get_the_title( $img ) ); ?>">
			</li>
			<?php
		}
		?>
	</ul>
</div>