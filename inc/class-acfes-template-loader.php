<?php

/**
 * Template loader for Acfes Component Plugin.
 *
 * Only need to specify class properties here.
 *
 */
class Acfes_Block_Template_Loader extends Gamajo_Block_Template_Loader {

	/**
	 * Prefix for filter names.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $filter_prefix = 'acfes';

	/**
	 * Directory name where custom templates for this plugin should be found in the theme.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $theme_template_directory = 'acfes-templates';

	/**
	 * Reference to the root directory path of this plugin.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $plugin_directory = ACFES_DIR;

}
