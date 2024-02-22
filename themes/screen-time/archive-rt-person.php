<?php
/**
 * Archive Person callback file
 *
 * @package screen-time
 */

get_header();
?>

<div class="person-archive-main">
	<div class="person-archive-container">
		<div class="container-heading">
			<div class="container-heading-line-archive"></div>
			<?php
			if ( isset( $_GET['movie-id'] ) && wp_verify_nonce( wp_unslash( $_GET['movie_nonce'] ), 'movie_nonce' ) ) { // phpcs:ignore
				$person_ids  = $_GET['movie-id']; // phpcs:ignore
				$person_data = get_cast_crew( $person_ids );
				?>
					<h1 class="container-heading-title-archive"><?php esc_html_e( 'Cast & Crew', 'screen-time' ); ?></h1>
				<?php
			} else {
				?>
					<h1 class="container-heading-title-archive"><?php esc_html_e( 'Celebrities', 'screen-time' ); ?></h1>
				<?php
			}
			?>
		</div>
		<div class="person-cards">
			<?php
			if ( ! isset( $person_data ) ) {
				get_template_part( 'template-parts/person/celebrities-page' );
			} else {
				?>
				<div class="person-cards-container-archive">
					<?php
					if ( ! empty( $person_data ) ) {

						foreach ( $person_data as $person ) {

							$person = get_post( $person )
							?>
							<div class="person-card-item" id="person-card">
								<?php
								if ( ! get_the_post_thumbnail_url( $person->ID ) ) {
									?>
									<img class="person-card-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/placeholder.jpg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
									<?php
								} else {
									?>
									<img class="person-card-image" src="<?php echo esc_url( get_the_post_thumbnail_url( $person->ID ) ); ?>" alt="<?php echo esc_attr( $person->post_title ); ?>" />
									<?php
								}
								?>
								
								<div class="person-card-detail">
									<h4 class="person-card-title">
										<?php
											echo esc_html( $person->post_title );
										?>
									</h4>
									<h4 class="person-card-date">
										<?php
											esc_html_e( 'Born - ', 'screen-time' );
											echo wp_kses( wp_date( 'd F Y', strtotime( get_post_meta( $person->ID, 'rt-person-meta-basic-birth-date', true ) ) ), 'screen-time' );
										?>
									</h4>
									<span class="person-card-exert">
										<?php
										if ( empty( $person->post_excerpt ) ) {
											echo wp_kses_post( wp_trim_words( $person->post_content, 18, '...' ) );
										} else {
											echo wp_kses_post( wp_trim_words( $person->post_excerpt, 18, '...' ) );
										}
										?>
									</span>
									<a href="<?php echo esc_url( get_permalink( $person->ID ) ); ?>" class="person-view-all">
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
									if ( ! get_the_post_thumbnail_url( $person->ID ) ) {
										?>
										<img class="person-card-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/placeholder.jpg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
										<?php
									} else {
										?>
										<img class="person-card-image" src="<?php echo esc_url( get_the_post_thumbnail_url( $person->ID ) ); ?>" alt="<?php esc_attr_e( 'person Image', 'screen-time' ); ?>" />
										<?php
									}
									?>
									<div class="first-part-details">
										<h4 class="person-card-title">
											<?php
												echo esc_html( $person->post_title );
											?>
										</h4>
										<h4 class="person-card-date">
											<?php
												esc_html_e( 'Born - ', 'screen-time' );
												echo wp_kses( wp_date( 'd F Y', strtotime( get_post_meta( $person->ID, 'rt-person-meta-basic-birth-date', true ) ) ), 'screen-time' );
											?>
										</h4>
									</div>
								</div>
								
								<div class="person-card-detail">
									
									<span class="person-card-exert">
										<?php
										if ( empty( $person->post_excerpt ) ) {
											echo wp_kses_post( wp_trim_words( $person->post_content, 18, '...' ) );
										} else {
											echo wp_kses_post( wp_trim_words( $person->post_excerpt, 18, '...' ) );
										}
										?>
									</span>
									<a href="<?php echo esc_url( get_permalink( $person->ID ) ); ?>" class="person-view-all">
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
				<?php
			}
			?>
			<div class="pagination-container">
				<?php
				screentime_pagination();
				?>
			</div>
			<!-- <div class="load-more-container">
				<button class="load-more-button">
					<?php esc_html_e( 'Load More', 'screen-time' ); ?>
				</button>
			</div> -->
		</div>
	</div>
</div>

<?php
get_footer();