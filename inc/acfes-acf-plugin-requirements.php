<?php
/**
 * This file registers the required plugins
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.5.2
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

if ( ! function_exists( 'acfes_register_required_plugins' ) ) {

	add_action( 'tgmpa_register', 'acfes_register_required_plugins' );
	/**
	 * Register the required plugins for this theme.
	 *
	 * The variable passed to tgmpa_register_plugins() should be an array of plugin
	 * arrays.
	 *
	 * This function is hooked into tgmpa_init, which is fired within the
	 * TGM_Plugin_Activation class constructor.
	 */
	function acfes_register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			// Include a plugin from an arbitrary external source in your theme.
			array(
				'name'             => 'Advanced Custom Fields Pro', // The plugin name.
				'slug'             => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
				'source'           => WP_PLUGIN_DIR . '/advanced-custom-fields-pro', // The plugin source.
				'required'         => true, // If false, the plugin is only 'recommended' instead of required.
				'force_activation' => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				//'external_url' => 'http://www.advancedcustomfields.com/pro/', // If set, overrides default API URL and points to an external URL.
			),

			// Include a plugin from a GitHub repository in your theme.
			// This presumes that the plugin code is based in the root of the GitHub repository
			// and not in a subdirectory ('/src') of the repository.
			array(
				'name'             => 'ACF Taxonomy Chooser',
				'slug'             => 'acf-taxonomy-chooser',
				'source'           => 'https://github.com/marktimemedia/acf-term-and-taxonomy-chooser/archive/master.zip',
				'required'         => true, // If false, the plugin is only 'recommended' instead of required.
				'force_activation' => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'external_url'     => 'https://github.com/marktimemedia/acf-term-and-taxonomy-chooser', // If set, overrides default API URL and points to an external URL.
			),

			array(
				'name'             => 'ACF Post Type Selector',
				'slug'             => 'acf-post-type-selector',
				'source'           => 'https://github.com/TimPerry/acf-post-type-selector/archive/master.zip',
				'required'         => true, // If false, the plugin is only 'recommended' instead of required.
				'force_activation' => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'external_url'     => 'https://github.com/TimPerry/acf-post-type-selector', // If set, overrides default API URL and points to an external URL.
			),

			// array(
			// 	'name'      => 'FacetWP',
			// 	'slug'      => 'facetwp',
			// 	'source'    => WP_PLUGIN_DIR . '/facetwp',
			// 	'required'     => false, // If false, the plugin is only 'recommended' instead of required.
			// 	'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			// 	'external_url' => 'https://facetwp.com', // If set, overrides default API URL and points to an external URL.
			// ),

		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'acfes',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'acfes-install-plugins', // Menu slug.
			'parent_slug'  => 'plugins.php',            // Parent menu slug.
			'capability'   => 'activate_plugins',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.

			'strings'      => array(
				'page_title'                     => __( 'Install Required Plugins', 'theme-slug' ),
				'menu_title'                     => __( 'Install Plugins', 'theme-slug' ),
				'installing'                     => __( 'Installing Plugin: %s', 'theme-slug' ), // %s = plugin name.
				'oops'                           => __( 'Something went wrong with the plugin API.', 'theme-slug' ),
				'notice_can_install_required'    => _n_noop(
					'This plugin requires the following plugin: %1$s.',
					'This plugin requires the following plugins: %1$s.',
					'theme-slug'
				), // %1$s = plugin name(s).
				'notice_can_install_recommended' => _n_noop(
					'This plugin recommends the following plugin: %1$s.',
					'This plugin recommends the following plugins: %1$s.',
					'theme-slug'
				), // %1$s = plugin name(s).
			),

		);

		tgmpa( $plugins, $config );
	}
}
