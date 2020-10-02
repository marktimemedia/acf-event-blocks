<?php
/**
 * @wordpress-plugin
 * Plugin Name:       ACF Event Schedule
 * Description:       Sessions, Speakers, and Sponsors for Events, built with Advanced Custom Fields
 * Version:           1.0.4
 * Author:            Marktime Media (h/t Road Warrior Creative)
 * Author URI:        https://marktimemedia.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       acfes
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Plugin directory
define( 'ACFES_DIR', plugin_dir_path( __FILE__ ) );

// Plugin File URL
define( 'PLUGIN_FILE_URL', __FILE__ );

// Includes
require_once ACFES_DIR . 'inc/config.php';
require_once ACFES_DIR . 'inc/settings.php';
require_once ACFES_DIR . 'inc/helpers.php';
require_once ACFES_DIR . 'inc/post-types.php';
require_once ACFES_DIR . 'inc/taxonomies.php';
require_once ACFES_DIR . 'inc/block-templates.php';
require_once ACFES_DIR . 'inc/schedule-output-functions.php';

require_once ACFES_DIR . 'inc/class-acfes-field-definitions.php';
require_once ACFES_DIR . 'inc/class-acfes-field-groups.php';
require_once ACFES_DIR . 'inc/class-acfes-field-add.php';
require_once ACFES_DIR . 'inc/class-acfes-block-template.php';
require_once ACFES_DIR . 'inc/class-gamajo-template-loader.php';
require_once ACFES_DIR . 'inc/class-acfes-template-loader.php';
require_once ACFES_DIR . 'inc/class-tgm-plugin-activation.php';
require_once ACFES_DIR . 'inc/acfes-acf-check-functions.php';
require_once ACFES_DIR . 'inc/acfes-acf-plugin-templates.php';
require_once ACFES_DIR . 'inc/acfes-acf-plugin-requirements.php';


// Primary Setup
class ACF_Event_Schedule_Plugin {

	/**
	 * Fired when plugin file is loaded.
	 */
	public function __construct() {

		add_action( 'admin_init', array( $this, 'acfes_admin_init' ) );
		add_action( 'admin_print_styles', array( $this, 'acfes_admin_css' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'acfes_admin_enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'acfes_enqueue_scripts' ) );
		// add_action( 'manage_posts_custom_column', array( $this, 'acfes_manage_post_types_columns_output' ), 10, 2 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'acfes_add_block_editor_assets' ) );
		add_action( 'plugins_loaded', array( 'Acfes_Block_Templates', 'get_instance' ) );
		add_action( 'acf/init', 'register_acfes_block_types' );

		register_block_type(
			'acfes/schedule-block',
			array(
				'editor_script'   => 'schedule-block',
				'attributes'      => array(
					'date'            => array( 'type' => 'string' ),
					'color_scheme'    => array( 'type' => 'string' ),
					'session_link'    => array( 'type' => 'string' ),
					'speaker_link'    => array( 'type' => 'string' ),
					'schedule_layout' => array( 'type' => 'string' ),
					'align'           => array( 'type' => 'string' ),
				),
				'render_callback' => array( $this, 'acfes_schedule_block_output' ),
			),
		);

		add_filter( 'manage_acfes_session_posts_columns', array( $this, 'acfes_manage_post_types_columns' ) );
		add_filter( 'manage_edit-acfes_session_sortable_columns', array( $this, 'acfes_manage_sortable_columns' ) );
		add_filter( 'display_post_states', array( $this, 'acfes_display_post_states' ) );
	}

	/**
	 * Runs during admin_init.
	 */
	public function acfes_admin_init() {
		add_action( 'pre_get_posts', array( $this, 'acfes_admin_pre_get_posts' ) );
	}

	/**
	 * Runs during pre_get_posts in admin.
	 *
	 * @param WP_Query $query
	 */
	public function acfes_admin_pre_get_posts( $query ) {
		if ( ! is_admin() || ! $query->is_main_query() ) {
			return;
		}

		$current_screen = get_current_screen();

		// Order by session time
		if ( 'edit-acfes_session' === $current_screen->id && $query->get( 'orderby' ) === '_acfes_session_time' ) {
			$query->set( 'meta_key', '_acfes_session_time' );
			$query->set( 'orderby', 'meta_value_num' );
		}
	}

	public function acfes_admin_enqueue_scripts() {
		global $acfes_post_type;

		// Enqueues scripts and styles for session admin page
		if ( 'acfes_session' === $acfes_post_type ) {
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_register_style( 'jquery-ui', plugins_url( '/assets/css/jquery-ui.css', __FILE__ ), array(), filemtime() );
			wp_enqueue_style( 'jquery-ui' );
		}
	}

	/**
	* Runs during enqueue_block_editor_assets
	*
	* @uses wp_enqueue_style()
	**/
	public function acfes_add_block_editor_assets() {
		wp_enqueue_style( 'acfes-editor', plugins_url( '/assets/css/acfes-editor-style.css', __FILE__ ), array(), 1 );
		wp_enqueue_script( 'schedule-block', plugin_dir_url( __FILE__ ) . 'assets/js/schedule-block.js', array( 'wp-blocks', 'wp-i18n', 'wp-editor' ), 1, true );
	}

	/**
	* Runs during wp_enqueue_script, adds CSS to frontend
	*/
	public function acfes_enqueue_scripts() {
		$mtm_countdown_options = array(
			'start'    => get_option( 'acfes_countdown_date' ),
			'end'      => get_option( 'acfes_countdown_end_time' ),
			'timezone' => get_option( 'timezone_string' ),
		);
		wp_enqueue_style( 'acfes-styles', plugins_url( '/assets/css/acfes-style.css', __FILE__ ), array(), 1 );
		wp_enqueue_script( 'acfes-moment', plugin_dir_url( __FILE__ ) . 'assets/js/moment.js', array(), 1, true );
		wp_enqueue_script( 'acfes-moment-data', plugin_dir_url( __FILE__ ) . 'assets/js/moment-timezone-with-data.js', array( 'acfes-moment' ), 1, true );
		wp_enqueue_script( 'countdown', plugin_dir_url( __FILE__ ) . 'assets/js/countdown.js', array(), 1, true );
		wp_localize_script( 'countdown', 'countdownOptions', $mtm_countdown_options );
	}

	/**
	 * Runs during admin_print_styles, adds CSS for custom admin columns and block editor
	 *
	 * @uses wp_enqueue_style()
	 */
	public function acfes_admin_css() {
		wp_enqueue_style( 'acfes-admin', plugins_url( '/assets/css/acfes-admin-style.css', __FILE__ ), array(), 1 );
	}

	/**
	 * Filters our custom post types columns.
	 *
	 * @uses current_filter()
	 * @see __construct()
	 */
	public function acfes_manage_post_types_columns( $columns ) {
		$current_filter = current_filter();

		switch ( $current_filter ) {
			case 'manage_acfes_session_posts_columns':
				$columns = array_slice( $columns, 0, 1, true ) + array( 'conference_session_time' => __( 'Time', 'acf-event-schedule' ) ) + array_slice( $columns, 1, null, true );
				break;
			default:
		}

		return $columns;
	}

	/**
	 * Custom columns output
	 *
	 * This generates the output to the extra columns added to the posts lists in the admin.
	 *
	 * @see acfes_manage_post_types_columns()
	 */
	public function acfes_manage_post_types_columns_output( $column, $post_id ) {
		switch ( $column ) {

			case 'conference_session_time':
				$session_time = strtotime( get_field( 'acfes_session_time', $post_id ) );
				$session_time = ( $session_time ) ? gmdate( get_option( 'time_format' ), $session_time ) : '&mdash;';
				echo esc_html( $session_time );
				break;

			default:
		}
	}

	/**
	 * Additional sortable columns for WP_Posts_List_Table
	 */
	public function acfes_manage_sortable_columns( $sortable ) {
		$current_filter = current_filter();

		if ( 'manage_edit-acfes_session_sortable_columns' === $current_filter ) {
			$sortable['conference_session_time'] = '_acfes_session_time';
		}

		return $sortable;
	}

	/**
	 * Display an additional post label if needed.
	 */
	public function acfes_display_post_states( $states ) {
		$post = get_post();

		if ( 'acfes_session' !== $post->post_type ) {
			return $states;
		}

		$session_type = get_field( 'acfes_session_type', $post->ID );
		if ( ! in_array( $session_type, array( 'session', 'custom', 'mainstage' ), true ) ) {
			$session_type = 'session';
		}

		if ( 'session' === $session_type ) {
			$states['acfes-session-type'] = __( 'Session', 'acf-event-schedule' );
		} elseif ( 'custom' === $session_type ) {
			$states['acfes-session-type'] = __( 'Break/Lunch', 'acf-event-schedule' );
		} elseif ( 'mainstage' === $session_type ) {
			$states['acfes-session-type'] = __( 'Mainstage', 'acf-event-schedule' );
		}

		return $states;
	}

	/**
	 * Schedule Block Dynamic content Output.
	 */
	public function acfes_schedule_block_output( $props ) {

		return acfes_schedule_output( $props );
	}

}

// Load the plugin class.
$GLOBALS['acfes_plugin'] = new ACF_Event_Schedule_Plugin();
