<?php
/**
 * Custom Widget for Movie.
 *
 * @package screen-time
 */

/**
 *  Class Movie_Widget for custom widget.
 */
class Movie_Widget extends WP_Widget {

	/**
	 * Method __construct
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct(
			'movie_widget',
			__( 'Movie Widget', 'screen-time' ),
			array(
				'description' => __( 'Display related movies based on specified criteria.', 'screen-time' ),
			)
		);
	}

	/**
	 * Method widget Display widget on frontend.
	 *
	 * @param $args     $args additional arguments.
	 * @param $instance $instance instance of the widget.
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {

		// collect our widget's information.
		$movie_title             = ! empty( $instance['movie-title'] ) ? $instance['movie-title'] : __( 'Related Movies', 'screen-time' );
		$movie_count             = ! empty( $instance['movie-count'] ) ? absint( $instance['movie-count'] ) : 3;
		$movie_relation_criteria = ! empty( $instance['movie-relation-criteria'] ) ? $instance['movie-relation-criteria'] : __( 'genre', 'screen-time' );
		?>
		<div class="trending-movie-main">
			<div class="trending-movie-container">
				<div class="container-heading">
					<div class="container-heading-line"></div>
					<h1 class="container-heading-title"><?php echo esc_html( $movie_title ); ?></h1>
				</div>
				<div class="movie-cards">
					<div class="movie-cards-container-archive">
						<?php

						// Collect the relevant movies based on the criteria.
						$movies = $this->get_relevant_movies( $movie_count, $movie_relation_criteria );

						if ( ! empty( $movies ) && is_array( $movies ) ) {
							foreach ( $movies as $movie ) {
								?>
								<div class="movie-card-item">
									<a href="<?php echo esc_url( get_permalink( $movie->ID ) ); ?>">
										<img class="movie-card-image" src="<?php echo esc_url( get_the_post_thumbnail_url( $movie->ID ) ); ?>" alt="<?php echo esc_attr( $movie->post_title ); ?>" />
									</a>
									<a href="<?php echo esc_url( get_permalink( $movie->ID ) ); ?>">
										<div class="movie-card-detail">
											<h4 class="movie-card-title">
												<?php
												echo esc_html( $movie->post_title );
												?>
											</h4>
											<h4 class="movie-card-genre">
												<?php
												if ( format_human_readable_duration( $movie->ID ) !== '' ) {
													echo esc_html( format_human_readable_duration( $movie->ID ) );
												} else {
													_e( ' - ', 'screen-time' );
												}
												?>
											</h4>
											<span class="movie-card-release-date">
												<?php
												echo esc_html( get_movie_card_genre( $movie->ID ) );
												?>
											</span>
											<span class="movie-card-content-rating">
												<?php
												echo esc_html( wp_date( 'Y', strtotime( get_post_meta( $movie->ID, 'rt-movie-meta-basic-release-date', true ) ) ) );
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
								echo esc_html( 'Sorry, No ' . $movie_title . ' Found' );
								?>
								</h2>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Method get_relevant_movies Collect the relevant movies based on the criteria.
	 *
	 * @param $movie_count             $movie_count no of movies to be displayed.
	 * @param $movie_relation_criteria $movie_relation_criteria taxonomy of movie based on movies filter.
	 *
	 * @return array
	 */
	protected function get_relevant_movies( $movie_count, $movie_relation_criteria ) {

		// Get the current post terms.
		$terms = get_the_terms( get_the_ID(), $movie_relation_criteria );

		// If no terms found, return empty array.
		if ( ! $terms || is_wp_error( $terms ) ) {
			return array();
		}

		$args = array(
			'post_type'      => 'rt-movie',
			'posts_per_page' => $movie_count,
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- Reason: I have to filter the posts based on taxonomy.
				array(
					'taxonomy' => $movie_relation_criteria,
					'field'    => 'term_id',
					'terms'    => wp_list_pluck( $terms, 'term_id' ),
				),
			),
		);

		// Get the posts based on the criteria.
		return get_posts( $args ); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.get_posts_get_posts -- Reason: it's a custom query. 
	}

	/**
	 * Method form Display widget form on widget area.
	 *
	 * @param $instance $instance instance of the widget.
	 *
	 * @return void
	 */
	public function form( $instance ) {

		// collect our widget's information if set.
		$movie_title       = isset( $instance['movie-title'] ) ? $instance['movie-title'] : __( 'Related Movies', 'screen-time' );
		$count             = isset( $instance['movie-count'] ) ? absint( $instance['movie-count'] ) : 3;
		$relation_criteria = isset( $instance['movie-relation-criteria'] ) ? $instance['movie-relation-criteria'] : __( 'genre', 'screen-time' );

		?>
			<label for="<?php echo esc_attr( $this->get_field_id( 'movie-title' ) ); ?>"><?php esc_html_e( 'Title:', 'screen-time' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'movie-title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'movie-title' ) ); ?>" type="text" value="<?php echo esc_attr( $movie_title ); ?>">

			<label for="<?php echo esc_attr( $this->get_field_id( 'movie-count' ) ); ?>"><?php esc_html_e( 'Count:', 'screen-time' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'movie-count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'movie-count' ) ); ?>" type="number" min="1" value="<?php echo esc_attr( $count ); ?>">

			<label for="<?php echo esc_attr( $this->get_field_id( 'movie-relation-criteria' ) ); ?>"><?php esc_html_e( 'Relation Criteria:', 'screen-time' ); ?></label>
			<?php
			// Get all the taxonomies of movie.
			$movie_taxonomies = get_object_taxonomies( 'rt-movie', 'object' );
			?>
			<select id="<?php echo esc_attr( $this->get_field_id( 'movie-relation-criteria' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'movie-relation-criteria' ) ); ?>">
			<?php foreach ( $movie_taxonomies as $taxonomy => $object ) : ?>
					<option value="<?php echo esc_attr( $taxonomy ); ?>" <?php selected( $relation_criteria, $taxonomy ); ?>><?php echo esc_html( $object->label ); ?></option>
				<?php endforeach; ?>
			</select>
		<?php
	}

	/**
	 * Method update Update the widget instance.
	 *
	 * @param $new_instance $new_instance old instance of the widget.
	 * @param $old_instance $old_instance new instance of the widget.
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {

		// Create an empty array for instance.
		$instance = array();

		// Collect instance information.
		$instance['movie-title']             = ( ! empty( $new_instance['movie-title'] ) ) ? sanitize_text_field( $new_instance['movie-title'] ) : '';
		$instance['movie-count']             = ( ! empty( $new_instance['movie-count'] ) ) ? absint( $new_instance['movie-count'] ) : 3;
		$instance['movie-relation-criteria'] = ( ! empty( $new_instance['movie-relation-criteria'] ) ) ? sanitize_text_field( $new_instance['movie-relation-criteria'] ) : __( 'genre', 'screen-time' );

		return $instance;
	}
}
