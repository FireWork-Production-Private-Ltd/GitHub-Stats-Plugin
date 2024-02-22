<?php
/**
 * Videos card template.
 *
 * @package screen-time
 */

?>

<div id="videos" class="section custom-container">
	<div class="section-title-wrap">
		<div class="container-heading">
			<div class="container-heading-line"></div>
			<h1 class="container-heading-title"><?php echo esc_html( $args['title'] ); ?></h1>
		</div>
	</div>
	<ul class="videos-list">
		<?php
		$videos = get_post_meta( get_the_ID(), 'rt-media-meta-video', true );
		$videos = json_decode( $videos );

		if ( ! is_array( $videos ) ) {
			$videos = array();
		}

		$videos = array_slice( $videos, 0, 3 );

		foreach ( $videos as $video_id ) {
			?>
			<div class="video-wrapper">
				<video controls class="videos" id="<?php echo esc_attr( 'video-' . $video_id ); ?>" preload="metadata">
					<?php
					if ( 'Videos' === $args['title'] ) {
						?>
						<source src="<?php echo esc_url( wp_get_attachment_url( $video_id ) . '#t=15.4' ); ?>" type="video/mp4">
						<?php
					} else {
						?>
						<source src="<?php echo esc_url( wp_get_attachment_url( $video_id ) . '#t=15.7' ); ?>" type="video/mp4">
						<?php
					}
					?>
				</video>
					
				<!-- <div class="play-button-wrapper">
					<div class="play-gif">
						<button class="custom-play-pause" onclick="togglePlayPause('video-<?php echo esc_attr( $video_id ); ?>')">
							<img src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/play-button.svg' ); ?>">
						</button>
					</div>
				</div> -->
			</div>
			<?php
		}
		?>
	</ul>
</div>