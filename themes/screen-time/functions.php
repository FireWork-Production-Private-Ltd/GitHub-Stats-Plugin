<?php
/**
 * Functions and definitions
 *
 * It contains setup theme, enqueue styles and scripts, register nav menus, etc. functions.
 *
 * @package screen-time
 */

if ( ! defined( 'SCREEN_TIME_DIR' ) ) {
	define( 'SCREEN_TIME_DIR', get_template_directory_uri() );
}

if ( ! defined( 'SCREEN_TIME_PATH' ) ) {
	define( 'SCREEN_TIME_PATH', get_template_directory() );
}

if ( ! function_exists( 'screentime_theme_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function screentime_theme_setup() {

		// Add theme support for selective.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 200,
				'width'       => 75,
				'flex-width'  => true,
				'flex-height' => true,
				'class-name'  => 'header-logo',
			)
		);

		// Add theme support for thumbnail.
		add_theme_support(
			'post-thumbnails',
			array( 'rt-movie', 'rt-person' )
		);

		// Register Primary and Footer Menus.
		register_nav_menus(
			array(
				'primary-menu' => esc_html__( 'Primary Menu', 'screen-time' ),
				'footer-menu'  => esc_html__( 'Footer Menu', 'screen-time' ),
				'company-menu' => esc_html__( 'Company Menu', 'screen-time' ),
				'social-menu'  => esc_html__( 'Social Menu', 'screen-time' ),
			)
		);

		register_sidebar(
			array(
				'name'         => __( 'Movie Quick Link', 'screen-time' ),
				'id'           => 'rt-movie-quick-link',
				'description'  => __( 'This widget displayed Quick links on movie single page', 'screen-time' ),
				'before_title' => '<h2 class="sidebar-container">',
				'after_title'  => '</h2>',
			),
		);

		register_sidebar(
			array(
				'name'         => __( 'Movie Sidebar', 'screen-time' ),
				'id'           => 'rt-movie-sidebar',
				'description'  => __( 'This widget displayed on single movie page', 'screen-time' ),
				'before_title' => '<h2 class="sidebar-container">',
				'after_title'  => '</h2>',
			),
		);

		register_sidebar(
			array(
				'name'         => __( 'Person Sidebar', 'screen-time' ),
				'id'           => 'rt-person-sidebar',
				'description'  => __( 'This sidebar content celebrity recommendation ', 'screen-time' ),
				'before_title' => '<h2 class="sidebar-container">',
				'after_title'  => '</h2>',
			),
		);
	}
}
add_action( 'after_setup_theme', 'screentime_theme_setup' );

/**
 * Add Custom Styles
 */
function custom_enqueue_styles() {

	// Register Custom CSS.
	wp_enqueue_style(
		'custom-style',
		SCREEN_TIME_DIR . '/style.css',
		array(),
		'1.0.0',
	);

	// Register Custom CSS for Header and Footer.
	wp_enqueue_style(
		'header-footer-style',
		SCREEN_TIME_DIR . '/assets/css/header-footer.css',
		array(),
		'1.0.0',
	);

	// Register Custom CSS for Home and Archive page.
	wp_enqueue_style(
		'home-archive-page-style',
		SCREEN_TIME_DIR . '/assets/css/home-archive-page.css',
		array(),
		'1.0.0',
	);

	// Register Custom CSS for Movie Single page.
	wp_enqueue_style(
		'movie-single-page-style',
		SCREEN_TIME_DIR . '/assets/css/movie-single-page.css',
		array(),
		'1.0.0',
	);

	// Register Custom CSS for Person Single page.
	wp_enqueue_style(
		'person-archive-page-style',
		SCREEN_TIME_DIR . '/assets/css/person-archive-page.css',
		array(),
		'1.0.0',
	);

	// Register Custom CSS for Person Single page.
	wp_enqueue_style(
		'person-single-page-style',
		SCREEN_TIME_DIR . '/assets/css/person-single-page.css',
		array(),
		'1.0.0',
	);

	// Register Custom CSS for Comment form.
	wp_enqueue_style(
		'comment-form-style',
		SCREEN_TIME_DIR . '/assets/css/comment-form.css',
		array(),
		'1.0.0',
	);
}

add_action( 'wp_enqueue_scripts', 'custom_enqueue_styles' );

/**
 * Ass Custom Scripts
 */
function custom_enqueue_scripts() {

	// Register Custom JS.
	wp_enqueue_script(
		'custom-script',
		SCREEN_TIME_DIR . '/assets/js/script.js',
		array(),
		'1.0.0',
		true
	);

	// Register Custom JS.
	wp_enqueue_script(
		'customizer-options-script',
		SCREEN_TIME_DIR . '/assets/js/customizer-options-save.js',
		array(),
		'1.0.0',
		true
	);

	$bg_color    = get_theme_mod( 'site-background-color-setting' );
	$nav_setting = get_theme_mod( 'single-page-navigation-setting' );
	wp_localize_script(
		'customizer-options-script',
		'themeCustomizerOption',
		array(
			'background_color' => $bg_color,
			'nav_setting'      => $nav_setting,
		),
	);
}

add_action( 'wp_enqueue_scripts', 'custom_enqueue_scripts' );

/**
 * Ass Custom Scripts
 */
function customizer_option_script() {

	// Register Custom JS.
	wp_enqueue_script(
		'customizer-option-script',
		SCREEN_TIME_DIR . '/assets/js/customizer-options.js',
		array(
			'customize-preview',
			'customize-selective-refresh',
		),
		'1.0.0',
		true
	);
}

add_action( 'customize_preview_init', 'customizer_option_script' );

/**
 * Method get_first_genre
 *
 * @param $id $id movie post ID.
 *
 * @return string
 */
function get_first_genre( $id ) {
	$genres = get_the_terms( $id, 'rt-movie-genre' );
	if ( ! empty( $genres ) ) {
		$genres = wp_list_pluck( $genres, 'name' )[0];
	}
	return $genres;
}

/**
 * Method get_formatted_release_date
 *
 * @param $id $id movie post ID.
 *
 * @return string
 */
function get_formatted_release_date( $id ) {
	return wp_date( 'd M Y', strtotime( get_post_meta( $id, 'rt-movie-meta-basic-release-date', true ) ) );
}

/**
 * Method get_content_rating
 *
 * @param $id $id movie post ID.
 *
 * @return string
 */
function get_content_rating( $id ) {
	return get_post_meta( $id, 'rt-movie-meta-basic-content-rating', true );
}

/**
 * Method get_movie_card_genre
 *
 * @param $id $id movie post ID.
 *
 * @return string
 */
function get_movie_card_genre( $id ) {
	if( get_the_terms( $id, 'rt-movie-genre' ) === '' ) {
		return '';
	}
	$term_names = get_the_terms( $id, 'rt-movie-genre' );
	if ( ! empty( $term_names ) && ! is_wp_error( $term_names ) ) {
		if ( empty( $term_names[1] ) ) {
			$genre_string = $term_names[0]->name;
		} else {
			$genre_string = $term_names[0]->name . ' • ' . $term_names[1]->name;
		}
	} else {
		return '';
	}
	return $genre_string;
}

/**
 * Method screentime_pagination to Display custom pagination.
 *
 * @return void
 */
function screentime_pagination() {

	$allowed_tags = array(
		'span' => array(
			'class' => array(),
		),
		'a'    => array(
			'class' => array(),
			'href'  => array(),
		),
	);

	$args = array(
		'prev_next' => false,
	);

	printf( '<nav class="screentime-pagination">%s</nav>', wp_kses( paginate_links( $args ), $allowed_tags ) );
}


/**
 * Method add_separator add special separator
 *
 * @return void
 */
function add_separator() {
	echo esc_html__( ' • ', 'screen-time' );
}

/**
 * Method get_cast_crew used to collect all cast and crew data.
 *
 * @param int $id current movie post ID.
 * @param int $limit how many cast and crew to display.
 *
 * @return array
 */
function get_cast_crew( int $id, int $limit = null ): array {

	// get all meta data.
	$directors = get_post_meta( $id, 'rt-movie-meta-crew-director', true );
	$writers   = get_post_meta( $id, 'rt-movie-meta-crew-writer', true );
	$producers = get_post_meta( $id, 'rt-movie-meta-crew-producer', true );
	$actors    = get_post_meta( $id, 'rt-movie-meta-crew-actor', true );

	$actors    = json_decode( $actors, true );
	$writers   = json_decode( $writers, true );
	$producers = json_decode( $producers, true );
	$directors = json_decode( $directors, true );

	$persons = array();

	if ( is_array( $actors ) ) {

		$persons = array_merge( $actors );
	}

	if ( is_array( $writers ) ) {

		$persons = array_merge( $persons, $writers );
	}

	if ( is_array( $producers ) ) {

		$persons = array_merge( $persons, $producers );
	}

	if ( is_array( $directors ) ) {

		$persons = array_merge( $persons, $directors );
	}

	// limit the data.
	if ( null === $limit && is_array( $persons ) ) {
		return $persons;
	}
	return array_slice( $persons, 0, $limit );
}

/**
 * Method wpdocs_custom_excerpt_length
 *
 * @return int
 */
function custom_except_length() {
	return 18;
}
add_filter( 'excerpt_length', 'custom_except_length', 11 );

/**
 * Sets the excerpt more text to an empty string.
 *
 * @return string The modified more text.
 */
function custom_except_more() {
	return '...';
}
add_filter( 'excerpt_more', 'custom_except_more', 11 );

/**
 * Method format_human_readable_duration for adding filter to change time format.
 *
 * @param $id     $id current post id.
 * @param $format $format time format.
 *
 * @return string
 */
function format_human_readable_duration( $id, $format = '' ) {
	if( get_post_meta( $id, 'rt-movie-meta-basic-runtime', true )  === '' ) {
		return '';
	}
	( 'HM' === $format ) ? add_filter( 'ngettext', 'custom_translation_duration_sort' ) : add_filter( 'ngettext', 'custom_translation_duration_long' );
	$duration = human_readable_duration( wp_date( 'H:i:s', get_post_meta( $id, 'rt-movie-meta-basic-runtime', true ) * 60 ) );
	( 'HM' === $format ) ? remove_filter( 'ngettext', 'custom_translation_duration_sort' ) : remove_filter( 'ngettext', 'custom_translation_duration_long' );

	$duration_parts = explode( ',', $duration );
	$duration       = implode( ' ', array_slice( $duration_parts, 0, 2 ) );
	return $duration;
}

/**
 * Method custom_translation_duration_sort
 *
 * @param $translation $translation translation string.
 *
 * @return mixed
 */
function custom_translation_duration_sort( $translation ) {
	$search  = array( 'hours', 'hour', 'minutes', 'minute', 'seconds', 'second' );
	$replace = array( 'H', 'H', 'M', 'M', 'S', 'S' );
	return str_replace( $search, $replace, $translation );
}

/**
 * Method custom_translation_duration_long
 *
 * @param $translation $translation translation string.
 *
 * @return mixed
 */
function custom_translation_duration_long( $translation ) {
	$search  = array( 'hours', 'hour', 'minutes', 'minute', 'seconds', 'second' );
	$replace = array( 'hr', 'hr', 'min', 'min', 'S', 'S' );
	return str_replace( $search, $replace, $translation );
}

require SCREEN_TIME_PATH . '/includes/class-walker-social-menu.php';
require SCREEN_TIME_PATH . '/includes/class-customizer-options.php';
require SCREEN_TIME_PATH . '/includes/class-movie-widget.php';
require SCREEN_TIME_PATH . '/includes/class-person-widget.php';

/**
 * Method register_custom_widgets
 *
 * @return mixed
 */
function register_custom_widgets() {
	register_widget( 'Movie_Widget' );
	register_widget( 'Person_Widget' );
}

add_action( 'widgets_init', 'register_custom_widgets' );
