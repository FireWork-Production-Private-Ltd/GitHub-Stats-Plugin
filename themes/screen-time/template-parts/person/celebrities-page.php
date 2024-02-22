<?php
/**
 * Celebrities Page Template
 *
 * @package screen-time
 */

?>
<div class="person-cards-container-archive">
	<?php

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();
			?>
			<div class="person-card-item" id="person-card">
				<?php
				if ( ! get_the_post_thumbnail() ) {
					?>
					<img class="person-card-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/placeholder.jpg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
					<?php
				} else {

					the_post_thumbnail(
						'full',
						array(
							'class' => 'person-card-image',
							'alt'   => 'Person Image',
						)
					);
					?>
					<?php
				}
				?>
				
				<div class="person-card-detail">
					<h4 class="person-card-title">
						<?php
							the_title();
						?>
					</h4>
					<h4 class="person-card-date">
						<?php
							esc_html_e( 'Born - ', 'screen-time' );
							echo wp_kses( wp_date( 'd F Y', strtotime( get_post_meta( get_the_ID(), 'rt-person-meta-basic-birth-date', true ) ) ), 'screen-time' );
						?>
					</h4>
					<span class="person-card-exert">
						<?php
						the_excerpt();
						?>
					</span>
					<a href="<?php the_permalink(); ?>" class="person-view-all">
						<?php
						esc_html_e( 'Learn more', 'screen-time' );
						?>
						<img class="star-icon" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/red-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'arrow-icon', 'screen-time' ); ?>" />
					</a>
				</div>
			</div>

			<div class="person-card-item-mobile">
				<div class="person-card-first-part">
					<?php
					if ( ! get_the_post_thumbnail_url( get_the_ID() ) ) {
						?>
						<img class="person-card-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/placeholder.jpg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
						<?php
					} else {
						?>
						<img class="person-card-image" src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID() ) ); ?>" alt="<?php the_title(); ?>" />
						<?php
					}
					?>
					<div class="first-part-details">
						<h4 class="person-card-title">
							<?php
								the_title();
							?>
						</h4>
						<h4 class="person-card-date">
							<?php
								esc_html_e( 'Born - ', 'screen-time' );
								echo wp_kses( wp_date( 'd F Y', strtotime( get_post_meta( get_the_ID(), 'rt-person-meta-basic-birth-date', true ) ) ), 'screen-time' );
							?>
						</h4>
					</div>
				</div>
				
				<div class="person-card-detail">
					
					<span class="person-card-exert">
						<?php
						the_excerpt();
						?>
					</span>
					<a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" class="person-view-all">
						<?php esc_html_e( 'Learn more', 'screen-time' ); ?>
						<img class="star-icon" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/red-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'arrow-icon', 'screen-time' ); ?>" />
					</a>
				</div>
			</div>
			<?php
		}
	} else {
		?>
		<div class="no-person-found">
			<h2 class="no-person-found-title">			
				<?php
				esc_html_e( 'No Person Found', 'screen-time' );
				?>
			</h2>
		</div> 	
		<?php
	}
	?>
</div>