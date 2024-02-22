<?php
/**
 * Customizer Options class.
 *
 * @package screen-time
 */

/**
 *  Class Customizer_Options for customizer options.
 *  - Site color option (Global Setting)
 *  - Setting for Single page pagination menu
 *  - Movie single page time and separator format
 *  - Person and Movie single page media size and sidebar size
 */
class Customizer_Options {

	/**
	 * Method __construct for Customizer_Options.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'site_background_color_option' ) );
		add_action( 'customize_register', array( $this, 'single_page_navigation_option' ) );
		add_action( 'customize_register', array( $this, 'site_time_and_separator_format' ) );
		add_action( 'customize_register', array( $this, 'site_movie_single_media_size_control' ) );
	}

	/**
	 * Method site_background_color_option used to add site background color option.
	 *
	 * @param $wp_customize $wp_customize global variable.
	 *
	 * @return void
	 */
	public function site_background_color_option( $wp_customize ) {

		// Customizer panel for all Screen time Theme Customizer Options.
		$wp_customize->add_panel(
			'custom-customizer-panel',
			array(
				'title'    => __( 'Screen-Time Customizer Options', 'screen-time' ),
				'priority' => 10,
			)
		);

		// Site Background Color section.
		$wp_customize->add_section(
			'site-background-color-section',
			array(
				'title'              => __( 'Site Background Color', 'screen-time' ),
				'description'        => __( 'You can change site Background color (Global Setting)', 'screen-time' ),
				'panel'              => 'custom-customizer-panel',
				'description_hidden' => true,
			)
		);

		// Site Background Color setting.
		$wp_customize->add_setting(
			'site-background-color-setting',
			array(
				'type'              => 'theme_mod',
				'default'           => '#1f1f1f',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			)
		);

		// Site Background Color control.
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'site-globals-control',
				array(
					'label'    => __( 'Site Background Color', 'screen-time' ),
					'section'  => 'site-background-color-section',
					'settings' => 'site-background-color-setting',
				)
			)
		);
	}

	/**
	 * Method site_background_color_option used to add site background color option.
	 *
	 * @param $wp_customize $wp_customize global variable.
	 *
	 * @return void
	 */
	public function single_page_navigation_option( $wp_customize ) {

		// Single page navigation section.
		$wp_customize->add_section(
			'single-page-navigation-section',
			array(
				'title'              => __( 'Single Page Navigation setting', 'screen-time' ),
				'description'        => __( 'You can manage single page pagination', 'screen-time' ),
				'panel'              => 'custom-customizer-panel',
				'description_hidden' => true,
				'active_callback'    => function () {
					return is_single();
				},
			)
		);

		// Single page navigation setting.
		$wp_customize->add_setting(
			'single-page-navigation-setting',
			array(
				'default'           => true,
				'sanitize_callback' => 'rest_sanitize_boolean',
				'transport'         => 'postMessage',
			)
		);

		// Single page navigation control.
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'single-page-navigation-control',
				array(
					'label'    => __( 'Single page Pagination', 'screen-time' ),
					'type'     => 'checkbox',
					'section'  => 'single-page-navigation-section',
					'settings' => 'single-page-navigation-setting',
				)
			)
		);
	}

	/**
	 * Method site_time_and_separator_format used to add site time and separator format option.
	 *
	 * @param $wp_customize $wp_customize global variable.
	 *
	 * @return void
	 */
	public function site_time_and_separator_format( $wp_customize ) {

		// Site time and separator format section.
		$wp_customize->add_section(
			'site-time-separator-section',
			array(
				'title'              => __( 'Runtime & Separator', 'screen-time' ),
				'description'        => __( 'Custom movie runtime format and text separator', 'screen-time' ),
				'panel'              => 'custom-customizer-panel',
				'active_callback'    => function () {
					return is_singular( 'rt-movie' );
				},
				'description_hidden' => true,
			)
		);

		// Movie runtime format setting.
		$wp_customize->add_setting(
			'movie-runtime-format-setting',
			array(
				'default'           => 'HH:MM',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		// Movie runtime format control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'site-runtime-format-control',
				array(
					'label'    => __( 'Runtime format', 'screen-time' ),
					'section'  => 'site-time-separator-section',
					'settings' => 'movie-runtime-format-setting',
					'type'     => 'radio',
					'choices'  => array(
						'HH:MM'   => __( 'HH:MM', 'screen-time' ),
						'Minutes' => __( 'Minutes', 'screen-time' ),
					),
				)
			)
		);

		// Movie separator format setting.
		$wp_customize->add_setting(
			'site-text-separator-setting',
			array(
				'default'           => '•',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		// Movie separator format control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'site-text-separator-control',
				array(
					'label'    => __( 'Separator format', 'screen-time' ),
					'section'  => 'site-time-separator-section',
					'settings' => 'site-text-separator-setting',
					'type'     => 'select',
					'choices'  => array(
						'-' => __( '-', 'screen-time' ),
						'•' => __( '•', 'screen-time' ),
						'=' => __( '=', 'screen-time' ),
						'*' => __( '*', 'screen-time' ),
						':' => __( ':', 'screen-time' ),
						',' => __( ',', 'screen-time' ),
						'|' => __( '|', 'screen-time' ),
					),
				)
			)
		);
	}

	/**
	 * Method site_movie_single_media_size_control for manage movie single media size and sidebar size.
	 *
	 * @param $wp_customize $wp_customize global variable.
	 *
	 * @return void
	 */
	public function site_movie_single_media_size_control( $wp_customize ) {

		// Sidebar width section.
		$wp_customize->add_section(
			'sidebar-size-section',
			array(
				'title'              => __( 'Sidebar Width', 'screen-time' ),
				'description'        => __( 'Controls the width of sidebar (in px, %, or other measurements)', 'screen-time' ),
				'panel'              => 'custom-customizer-panel',
				'active_callback'    => function () {
					return is_single();
				},
				'description_hidden' => true,
			)
		);

		// Sidebar width setting.
		$wp_customize->add_setting(
			'sidebar-size-setting',
			array(
				'default'           => '280px',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		// Sidebar width control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'sidebar-size-control',
				array(
					'label'    => __( 'Sidebar Width Setting', 'screen-time' ),
					'section'  => 'sidebar-size-section',
					'settings' => 'sidebar-size-setting',
					'type'     => 'text',
				)
			)
		);

		// Movie single page media size section.
		$wp_customize->add_section(
			'single-movie-page-poster-size-section',
			array(
				'title'              => __( 'Movie Featured Image Size', 'screen-time' ),
				'description'        => __( 'Controls the height and width of the poster/profile picture', 'screen-time' ),
				'panel'              => 'custom-customizer-panel',
				'active_callback'    => function () {
					return is_singular( 'rt-movie' );
				},
				'description_hidden' => true,
			)
		);

		// Movie single page media width setting.
		$wp_customize->add_setting(
			'single-movie-page-poster-width-setting',
			array(
				'default'           => '592px',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		// Movie single page media width control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'single-movie-page-poster-width-control',
				array(
					'label'    => __( 'Featured Image Width', 'screen-time' ),
					'section'  => 'single-movie-page-poster-size-section',
					'settings' => 'single-movie-page-poster-width-setting',
					'type'     => 'text',
				)
			)
		);

		// Movie single page media height setting.
		$wp_customize->add_setting(
			'single-movie-page-poster-height-setting',
			array(
				'default'           => '876px',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		// Movie single page media height control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'single-movie-page-poster-height-control',
				array(
					'label'    => __( 'Featured Image Height', 'screen-time' ),
					'section'  => 'single-movie-page-poster-size-section',
					'settings' => 'single-movie-page-poster-height-setting',
					'type'     => 'text',
				)
			)
		);

		// Person single page media size section.
		$wp_customize->add_section(
			'single-person-page-poster-size-section',
			array(
				'title'              => __( 'Person Featured Image Size', 'screen-time' ),
				'description'        => __( 'Controls the height and width of the poster/profile picture', 'screen-time' ),
				'panel'              => 'custom-customizer-panel',
				'active_callback'    => function () {
					return is_singular( 'rt-person' );
				},
				'description_hidden' => true,
			)
		);

		// Person single page media width setting.
		$wp_customize->add_setting(
			'single-person-page-poster-width-setting',
			array(
				'default'           => '488px',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		// Person single page media width control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'single-person-page-poster-width-control',
				array(
					'label'    => __( 'Featured Image Width', 'screen-time' ),
					'section'  => 'single-person-page-poster-size-section',
					'settings' => 'single-person-page-poster-width-setting',
					'type'     => 'text',
				)
			)
		);

		// Person single page media height setting.
		$wp_customize->add_setting(
			'single-person-page-poster-height-setting',
			array(
				'default'           => '572px',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		// Person single page media height control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'single-person-page-poster-height-control',
				array(
					'label'    => __( 'Featured Image Height', 'screen-time' ),
					'section'  => 'single-person-page-poster-size-section',
					'settings' => 'single-person-page-poster-height-setting',
					'type'     => 'text',
				)
			)
		);
	}
}
new Customizer_Options();
