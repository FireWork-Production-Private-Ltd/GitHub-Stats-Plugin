<?php
/**
 * Custom Widget for Person.
 *
 * @package screen-time
 */

/**
 *  Class Person_Widget for custom widget.
 */
class Person_Widget extends WP_Widget {

	/**
	 * Method __construct
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct(
			'person_widget',
			__( 'Person Widget', 'screen-time' ),
			array(
				'description' => __( 'Display celebrity recommendation on single person page', 'screen-time' ),
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
		$person_title             = ! empty( $instance['person-title'] ) ? $instance['person-title'] : __( 'Celebrity Recommendations', 'screen-time' );
		$person_count             = ! empty( $instance['person-count'] ) ? absint( $instance['person-count'] ) : 4;
		$person_relation_criteria = ! empty( $instance['person-relation-criteria'] ) ? $instance['person-relation-criteria'] : __( 'career', 'screen-time' );
		?>
		<div class="person-archive-main">
			<div class="person-archive-container">
				<div class="section-title-wrap">
					<div class="container-heading">
						<div class="container-heading-line"></div>
						<h1 class="container-heading-title"><?php echo esc_html( $person_title ); ?></h1>
					</div>
				</div>
				<div>
					<div class="person-cards-container-archive">
						<?php
						// Collect the relevant person based on the criteria.
						$person_data = $this->get_relevant_person( $person_count, $person_relation_criteria );

						if ( ! empty( $person_data ) && is_array( $person_data ) ) {

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
							<div class="no-movie-found">
								<h2 class="no-movie-found-title">			
								<?php
								echo esc_html( 'Sorry, No ' . $person_title . ' Found' );
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
	 * Method get_relevant_person Collect the relevant persons based on the criteria.
	 *
	 * @param $person_count             $person_count no of person to be displayed.
	 * @param $person_relation_criteria $person_relation_criteria taxonomy of person based on persons filter.
	 *
	 * @return array
	 */
	protected function get_relevant_person( $person_count, $person_relation_criteria ) {

		// Get the current post terms.
		$terms = get_the_terms( get_the_ID(), $person_relation_criteria );

		// If no terms found, return empty array.
		if ( ! $terms || is_wp_error( $terms ) ) {
			return array();
		}

		$args = array(
			'post_type'      => 'rt-person',
			'posts_per_page' => $person_count,
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- Reason: I have to filter the posts based on taxonomy.
				array(
					'taxonomy' => $person_relation_criteria,
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
		$person_title      = isset( $instance['person-title'] ) ? $instance['person-title'] : __( 'Celebrity Recommendations', 'screen-time' );
		$count             = isset( $instance['person-count'] ) ? absint( $instance['person-count'] ) : 4;
		$relation_criteria = isset( $instance['person-relation-criteria'] ) ? $instance['person-relation-criteria'] : __( 'career', 'screen-time' );

		?>
			<label for="<?php echo esc_attr( $this->get_field_id( 'person-title' ) ); ?>"><?php esc_html_e( 'Title:', 'screen-time' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'person-title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'person-title' ) ); ?>" type="text" value="<?php echo esc_attr( $person_title ); ?>">

			<label for="<?php echo esc_attr( $this->get_field_id( 'person-count' ) ); ?>"><?php esc_html_e( 'Count:', 'screen-time' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'person-count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'person-count' ) ); ?>" type="number" min="1" value="<?php echo esc_attr( $count ); ?>">

			<label for="<?php echo esc_attr( $this->get_field_id( 'person-relation-criteria' ) ); ?>"><?php esc_html_e( 'Relation Criteria:', 'screen-time' ); ?></label>
			<?php
			// Get all the taxonomies of person.
			$person_taxonomies = get_object_taxonomies( 'rt-person', 'object' );
			?>
			<select id="<?php echo esc_attr( $this->get_field_id( 'person-relation-criteria' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'person-relation-criteria' ) ); ?>">
			<?php foreach ( $person_taxonomies as $taxonomy => $object ) : ?>
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
		$instance['person-title']             = ( ! empty( $new_instance['person-title'] ) ) ? sanitize_text_field( $new_instance['person-title'] ) : '';
		$instance['person-count']             = ( ! empty( $new_instance['person-count'] ) ) ? absint( $new_instance['person-count'] ) : 4;
		$instance['person-relation-criteria'] = ( ! empty( $new_instance['person-relation-criteria'] ) ) ? sanitize_text_field( $new_instance['person-relation-criteria'] ) : __( 'career', 'screen-time' );

		return $instance;
	}
}
