<?php
/**
* Customizer
*/
function acfes_archive_options( $wp_customize ) {

	$wp_customize->add_section(
		'acfes_events_options',
		array(
			'title'          => __( 'Event Options' ),
			'description'    => __( 'Options for managing custom events' ),
			'panel'          => '', // Not typically needed.
			'priority'       => 99,
			'capability'     => 'manage_options',
			'theme_supports' => '', // Rarely needed.
		)
	);

	// Countdown Start
	$wp_customize->add_setting(
		'acfes_countdown_date',
		array(
			'transport' => 'refresh',
			'type'      => 'option',
		)
	);

	$wp_customize->add_control(
		'acfes_countdown_date',
		array(
			'label'       => __( 'Coundtown Date/Time: Event Start' ),
			'description' => sprintf( 'Start time and date for the live event. Also powers the Countdown block. Your current <a href="/wp-admin/options-general.php">website timezone</a> is set to %s.', wp_timezone_string() ),
			'section'     => 'acfes_events_options',
			'priority'    => 1, // Optional. Order priority to load the control. Default: 10
			'type'        => 'datetime-local',
			'capability'  => 'manage_options',
		)
	);

	// Countdown End
	$wp_customize->add_setting(
		'acfes_countdown_end_time',
		array(
			'transport' => 'refresh',
			'type'      => 'option',
		)
	);

	$wp_customize->add_control(
		'acfes_countdown_end_time',
		array(
			'label'       => __( 'Coundtown Date/Time: Event End' ),
			'description' => esc_html__( 'Date and time the live event is over' ),
			'section'     => 'acfes_events_options',
			'priority'    => 1, // Optional. Order priority to load the control. Default: 10
			'type'        => 'datetime-local',
			'capability'  => 'manage_options',
		)
	);

	function acfes_sanitize_date_time( $input ) {
		$date = new DateTime( $input );
		return $date->format( 'Y-m-d h:m:s' );
	}

	// Base URL
	$wp_customize->add_setting(
		'acfes_base_url',
		array(
			'transport' => 'refresh',
			'type'      => 'option',
		)
	);

	$wp_customize->add_control(
		'acfes_base_url',
		array(
			'label'       => __( 'Schedule URL' ),
			'description' => esc_html__( 'Add the URL for your primary schedule page here. This will power the "return to schedule" link on individual session pages.' ),
			'section'     => 'acfes_events_options',
			'priority'    => 1, // Optional. Order priority to load the control. Default: 10
			'type'        => 'url',
			'capability'  => 'manage_options',
		)
	);

	// Session Archive
	$wp_customize->add_setting(
		'acfes_session_archive_type',
		array(
			'default'   => 'option-list',
			'transport' => 'refresh',
			'type'      => 'option',
		)
	);

	$wp_customize->add_control(
		'acfes_session_archive_type',
		array(
			'label'       => __( 'Session Archive' ),
			'description' => esc_html__( 'Choose whether sessions should display as a grid or a list by default' ),
			'section'     => 'acfes_events_options',
			'priority'    => 10, // Optional. Order priority to load the control. Default: 10
			'type'        => 'select',
			'capability'  => 'manage_options',
			'choices'     => array( // Optional.
				'option-grid' => __( 'Grid' ),
				'option-list' => __( 'List' ),
			),
		)
	);

	// Speaker Archive
	$wp_customize->add_setting(
		'acfes_speaker_archive_type',
		array(
			'default'   => 'option-grid',
			'transport' => 'refresh',
			'type'      => 'option',
		)
	);

	$wp_customize->add_control(
		'acfes_speaker_archive_type',
		array(
			'label'       => __( 'Speaker Archive' ),
			'description' => esc_html__( 'Choose whether speakers should display as a grid or a list by default' ),
			'section'     => 'acfes_events_options',
			'priority'    => 10, // Optional. Order priority to load the control. Default: 10
			'type'        => 'select',
			'capability'  => 'manage_options',
			'choices'     => array( // Optional.
				'option-grid' => __( 'Grid' ),
				'option-list' => __( 'List' ),
			),
		)
	);

	// Sponsor Archive
	$wp_customize->add_setting(
		'acfes_sponsor_archive_type',
		array(
			'default'   => 'option-list',
			'transport' => 'refresh',
			'type'      => 'option',
		)
	);

	$wp_customize->add_control(
		'acfes_sponsor_archive_type',
		array(
			'label'       => __( 'Sponsor Archive' ),
			'description' => esc_html__( 'Choose whether sponsors should display as a grid or a list by default' ),
			'section'     => 'acfes_events_options',
			'priority'    => 10, // Optional. Order priority to load the control. Default: 10
			'type'        => 'select',
			'capability'  => 'manage_options',
			'choices'     => array( // Optional.
				'option-grid' => __( 'Grid' ),
				'option-list' => __( 'List' ),
			),
		)
	);

	// Exhibitor Archive
	$wp_customize->add_setting(
		'acfes_exhibitor_archive_type',
		array(
			'default'   => 'option-list',
			'transport' => 'refresh',
			'type'      => 'option',
		)
	);

	$wp_customize->add_control(
		'acfes_exhibitor_archive_type',
		array(
			'label'       => __( 'Exhibitor Archive' ),
			'description' => esc_html__( 'Choose whether exhibitor should display as a grid or a list by default' ),
			'section'     => 'acfes_events_options',
			'priority'    => 10, // Optional. Order priority to load the control. Default: 10
			'type'        => 'select',
			'capability'  => 'manage_options',
			'choices'     => array( // Optional.
				'option-grid' => __( 'Grid' ),
				'option-list' => __( 'List' ),
			),
		)
	);

	// Countdown Start
	$wp_customize->add_setting(
		'acfes_grid_per_row',
		array(
			'default'   => 3,
			'transport' => 'refresh',
			'type'      => 'option',
		)
	);

	$wp_customize->add_control(
		'acfes_grid_per_row',
		array(
			'label'       => __( 'Grid Items Per Row' ),
			'description' => __( 'If you display items in a grid, how many items should display per row?' ),
			'section'     => 'acfes_events_options',
			'priority'    => 10, // Optional. Order priority to load the control. Default: 10
			'type'        => 'number',
			'capability'  => 'manage_options',
			'input_attrs' => array(
				'min'  => 2,
				'max'  => 6,
				'step' => 1,
			),
		)
	);

}
add_action( 'customize_register', 'acfes_archive_options' );
