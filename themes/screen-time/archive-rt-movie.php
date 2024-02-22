<?php
/**
 * Archive Movie callback file
 *
 * @package screen-time
 */

get_header();
?>

<div class="trending-movie-main">
	<div class="trending-movie-container">
		<div class="container-heading">
			<div class="container-heading-line-archive"></div>
			<h1 class="container-heading-title-archive"><?php esc_html_e( 'Movies', 'screen-time' ); ?></h1>
		</div>
		<div class="movie-cards">
			<div class="movie-cards-container-archive">
				<?php
				if ( have_posts() ) {

					while ( have_posts() ) {
						the_post();
						?>
						<div class="movie-card-item">
							<a href="<?php the_permalink(); ?>">
								<?php
								// the_post_thumbnail(
								// 'full',
								// array(
								// 'class' => 'movie-card-image',
								// 'alt'   => 'Movie Image',
								// )
								// );
								if ( ! get_the_post_thumbnail_url( get_the_ID() ) ) {
									?>
									<img class="movie-card-image" src="<?php echo esc_url( SCREEN_TIME_DIR . '/assets/images/placeholder.jpg' ); ?>" alt="<?php esc_attr_e( 'placeholder-image', 'screen-time' ); ?>"/>
									<?php
								} else {
									the_post_thumbnail(
										'full',
										array(
											'class' => 'movie-card-image',
											'alt'   => 'Movie Image',
										)
									);
								}
								?>

								
							</a>
							<a href="<?php the_permalink(); ?>">
								<div class="movie-card-detail">
									<h4 class="movie-card-title">
										<?php
										if ( get_the_title() === '' ) {
											_e( 'No Title', 'screen-time' );
										} else {
											the_title();
										}
										?>
									</h4>
									<h4 class="movie-card-genre">
										<?php
										if ( format_human_readable_duration( get_the_ID() ) !== '' ) {
											echo esc_html( format_human_readable_duration( get_the_ID() ) );
										} else {
											_e( ' - ', 'screen-time' );
										}
										?>
									</h4>
									<span class="movie-card-release-date">
										<?php
										if ( get_movie_card_genre( get_the_ID() ) !== '' ) {
											echo esc_html( get_movie_card_genre( get_the_ID() ) );
										} else {
											_e( ' - ', 'screen-time' );
										}
										?>
									</span>
									<span class="movie-card-content-rating">
										<?php
										if ( get_post_meta( get_the_ID(), 'rt-movie-meta-basic-release-date', true )  !== '' ) {
											echo esc_html( wp_date( 'Y', strtotime( get_post_meta( get_the_ID(), 'rt-movie-meta-basic-release-date', true ) ) ) );
										} else {
											_e( ' - ', 'screen-time' );
										}
										
										?>
									</span>
								</div>
							</a>
						</div>
						<?php
					}
					wp_reset_postdata();
				} else {
					?>
					<div class="no-movie-found">
						<h2 class="no-movie-found-title">			
							<?php
							esc_html_e( 'No Movie Found', 'screen-time' );
							?>
						</h2>
					</div> 	
					<?php
				}
				?>
			</div>
			<div class="pagination-container">
				<?php
				screentime_pagination();
				?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();