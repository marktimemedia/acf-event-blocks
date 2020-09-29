<?php
/**
 * Defining fields for modular content
 *
 * @package Acfes_Field_Definitions
 * @author Marktime Media
 **/
class Acfes_Block_Field_Definitions {

	// single scroll page select
	public function acfes_block_single_scroll_page_select( $label = 'Select Single Scroll Pages' ) {

		return apply_filters(
			'acfes_block_single_scroll_page_select_filter',
			array(
				'key'               => 'field_565e2fa2c08cbacfes',
				'label'             => $label,
				'name'              => 'acfes_select_pages',
				'type'              => 'relationship',
				'instructions'      => 'Select and re-order other pages, which will display in sections below the main content on this page.',
				'required'          => 0,
				'conditional_logic' => '',
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'post_type'         => array(
					0 => 'page',
				),
				'taxonomy'          => array(),
				'filters'           => array(
					0 => 'search',
					1 => 'post_type',
					2 => 'taxonomy',
				),
				'elements'          => array(
					0 => 'featured_image',
				),
				'min'               => '',
				'max'               => '',
				'return_format'     => 'object',
			)
		);
	}

	// Show Jump Button?
	public static function acfes_enable_jump_button( $label = 'Enable Back To Top?' ) {
		return apply_filters(
			'acfes_enable_jump_button_filter',
			array(
				'key'               => 'field_84gfkd945yd058acfes',
				'label'             => $label,
				'name'              => 'acfes_enable_jump_button',
				'type'              => 'true_false',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'message'           => 'Yes, show a back to top button in all single scroll sections (unchecking this will hide the button)',
				'default_value'     => 0,
			)
		);
	}

} // END class
