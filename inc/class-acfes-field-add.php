<?php
/**
 * Registers all ACF Fields
 *
 * To filter the layouts directly:
 *
 * function my_acfes_layouts_filter( $array ){
 *
 * // Add new fields to the end of the array
 * array_push( $array, array( 'my_key' => my_array_function() ) );
 *
 * // Remove existing fields from the array
 * unset( $array['field_key'] );
 *
 * return $array;
 * }
 * add_filter( 'acfes_content_modules_layouts_filter', 'my_acfes_layouts_filter' );
 */

/**
* Modular Fields
*/
class Acfes_Acf_Add_Local_Block_Field_Groups extends Acfes_Block_Field_Groups {

	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'acfes_add_field_groups' ), 2 );
		// add_filter( 'acf/settings/save_json', array( $this, 'get_local_json_path' ) );
		add_filter( 'acf/settings/load_json', array( $this, 'add_local_json_path' ) );
	}

	public function acfes_add_field_groups() {

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group( $this->acfes_template_block_single_scroll() );
			acf_add_local_field_group( $this->acfes_enable_jump_button() );
		}
	}

	/**
	 * Define where the local JSON is saved
	 *
	 * @return string
	 */
	public function get_local_json_path() {
		return WP_PLUGIN_DIR . '/acf-events-schedule/acfes-json';
	}

	/**
	 * Add our path for the local JSON
	 *
	 * @param array $paths
	 *
	 * @return array
	 */
	public function add_local_json_path( $paths ) {
		$paths[] = WP_PLUGIN_DIR . '/acf-events-schedule/acfes-json';
		return $paths;
	}

} // END class

new Acfes_Acf_Add_Local_Block_Field_Groups();


/**
* ACF Filters
*/
function acfes_unix_timestamp( $value, $post_id, $field ) {
	return strtotime( $value );
}
add_filter( 'acf/update_value/type=date_time_picker', 'acfes_unix_timestamp', 10, 3 );

/**
 * Registers Block Categories
 */

function acfes_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug'     => 'acfes-event-blocks',
				'title'    => __( 'Event Blocks', 'acfes' ),
				'priority' => 1,
			),
		)
	);
}
add_filter( 'block_categories', 'acfes_block_category', 10, 2 );

/**
* Register Block Types
*/

function register_acfes_block_types() {

	if ( function_exists( 'acf_register_block_type' ) ) {

		// Event List
		acf_register_block_type(
			array(
				'name'            => 'acfes_block_list_posts',
				'title'           => __( 'Event List Block' ),
				'description'     => __( 'Select existing event content (speakers, sessions, sponsors, exhibitors) that will be displayed in a list format' ),
				'render_template' => ACFES_DIR . 'templates/acfes-wrapper-event-list.php',
				'category'        => 'acfes-event-blocks',
				'icon'            => 'excerpt-view',
				'keywords'        => array( 'list', 'event' ),
				'mode'            => 'preview',
			)
		);

		// Event Grid
		acf_register_block_type(
			array(
				'name'            => 'acfes_block_grid_posts',
				'title'           => __( 'Event Grid Block' ),
				'description'     => __( 'Select existing event content (speakers, sessions, sponsors, exhibitors) that will be displayed in a grid format' ),
				'render_template' => ACFES_DIR . 'templates/acfes-wrapper-event-grid.php',
				'category'        => 'acfes-event-blocks',
				'icon'            => 'grid-view',
				'keywords'        => array( 'grid', 'event' ),
				'mode'            => 'preview',
			)
		);

		// Event Single
		acf_register_block_type(
			array(
				'name'            => 'acfes_block_single_post',
				'title'           => __( 'Event Single Block' ),
				'description'     => __( 'Select a single existing Event item (speaker, session, sponsor, exhibitor)' ),
				'render_template' => ACFES_DIR . 'templates/acfes-wrapper-event-single.php',
				'category'        => 'acfes-event-blocks',
				'icon'            => 'index-card',
				'keywords'        => array( 'single post', 'event' ),
				'mode'            => 'peview',
			)
		);

		// Event Embed
		acf_register_block_type(
			array(
				'name'            => 'acfes_block_embed',
				'title'           => __( 'Event Embed Block' ),
				'description'     => __( 'Embed video content via a URL or iFrame' ),
				'render_template' => ACFES_DIR . 'templates/acfes-block-embed.php',
				'category'        => 'acfes-event-blocks',
				'icon'            => 'format-video',
				'keywords'        => array( 'video', 'embed', 'event' ),
				'mode'            => 'preview',
			)
		);

		// Event Countdown
		acf_register_block_type(
			array(
				'name'            => 'acfes_block_countdown',
				'title'           => __( 'Event Countdown Block' ),
				'description'     => __( 'Countdown to the event and then display next session' ),
				'render_template' => ACFES_DIR . 'templates/acfes-block-countdown.php',
				'category'        => 'acfes-event-blocks',
				'icon'            => 'clock',
				'keywords'        => array( 'countdown', 'event' ),
				'mode'            => 'preview',
			)
		);

		// Event Contact Info
		acf_register_block_type(
			array(
				'name'            => 'acfes_block_meta',
				'title'           => __( 'Exhibitor/Sponsor Contact Info' ),
				'description'     => __( 'Show the additional information for this content (social, links, files, contact info, etc)' ),
				'render_template' => ACFES_DIR . 'templates/acfes-wrapper-event-meta.php',
				'category'        => 'acfes-event-blocks',
				'icon'            => 'info',
				'keywords'        => array( 'meta', 'event' ),
				'mode'            => 'edit',
				'post_types'      => array( 'acfes_sponsor', 'acfes_exhibitor' ),
			)
		);

		// Event Speaker Contact Info
		acf_register_block_type(
			array(
				'name'            => 'acfes_block_speaker_meta',
				'title'           => __( 'Speaker Contact Info' ),
				'description'     => __( 'Show the additional information for this speaker (social, links, etc)' ),
				'render_template' => ACFES_DIR . 'templates/acfes-wrapper-speaker-meta.php',
				'category'        => 'acfes-event-blocks',
				'icon'            => 'info',
				'keywords'        => array( 'meta', 'event' ),
				'mode'            => 'edit',
				'post_types'      => array( 'acfes_speaker' ),
			)
		);

		// Event Session Meta
		acf_register_block_type(
			array(
				'name'            => 'acfes_block_session_meta',
				'title'           => __( 'Session Info' ),
				'description'     => __( 'Show the additional information for this session (time, tracks, speakers, location, etc)' ),
				'render_template' => ACFES_DIR . 'templates/acfes-wrapper-session-meta.php',
				'category'        => 'acfes-event-blocks',
				'icon'            => 'info',
				'keywords'        => array( 'meta', 'event' ),
				'mode'            => 'edit',
				'post_types'      => array( 'acfes_session' ),
			)
		);

		// My Speakers
		acf_register_block_type(
			array(
				'name'            => 'acfes_block_speaker_list',
				'title'           => __( 'Show Speakers' ),
				'description'     => __( 'Show a list of speakers associated with this content' ),
				'render_template' => ACFES_DIR . 'templates/acfes-block-my-speaker-list.php',
				'category'        => 'acfes-event-blocks',
				'icon'            => 'list-view',
				'keywords'        => array( 'meta', 'event' ),
				'mode'            => 'edit',
				'post_types'      => array( 'acfes_session', 'acfes_sponsor', 'acfes_exhibitor' ),
			)
		);

		// My Sessions
		acf_register_block_type(
			array(
				'name'            => 'acfes_block_session_list',
				'title'           => __( 'Show Sessions' ),
				'description'     => __( 'Show a list of sessions associated with this content' ),
				'render_template' => ACFES_DIR . 'templates/acfes-block-my-session-list.php',
				'category'        => 'acfes-event-blocks',
				'icon'            => 'list-view',
				'keywords'        => array( 'meta', 'event' ),
				'mode'            => 'edit',
				'post_types'      => array( 'acfes_speaker', 'acfes_sponsor', 'acfes_exhibitor' ),
			)
		);

			// My Sponsors
		acf_register_block_type(
			array(
				'name'            => 'acfes_block_sponsor_list',
				'title'           => __( 'Show Sponsors' ),
				'description'     => __( 'Show a list of sponsors associated with this content' ),
				'render_template' => ACFES_DIR . 'templates/acfes-block-my-sponsor-list.php',
				'category'        => 'acfes-event-blocks',
				'icon'            => 'list-view',
				'keywords'        => array( 'meta', 'event' ),
				'mode'            => 'edit',
				'post_types'      => array( 'acfes_speaker', 'acfes_session', 'acfes_exhibitor' ),
			)
		);

			// My Files
		acf_register_block_type(
			array(
				'name'            => 'acfes_block_file_list',
				'title'           => __( 'Show Downloads' ),
				'description'     => __( 'Show downloads associated with this content' ),
				'render_template' => ACFES_DIR . 'templates/acfes-block-my-file-list.php',
				'category'        => 'acfes-event-blocks',
				'icon'            => 'list-view',
				'keywords'        => array( 'meta', 'event' ),
				'mode'            => 'edit',
				'post_types'      => array( 'acfes_session', 'acfes_sponsor', 'acfes_exhibitor' ),
			)
		);
	}
}
