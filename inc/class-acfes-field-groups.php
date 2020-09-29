<?php
/**
 * Contains the default values for all modular field groups
 *
 * @package Acfes_Field_Definitions
 * @author Marktime Media
 **/
class Acfes_Block_Field_Groups extends Acfes_Block_Field_Definitions {

	/**
	* Label for Modular Boxes
	*/
	public static $str_label = 'Add Blocks';

	/**
	* Array of Locations
	*/
	public static $arr_location = array(
		array(
			'param'    => 'blocktemplates',
			'operator' => '==',
			'value'    => '../templates/template-single-scroll.php',
		),
	);

	/**
	* Unique Key
	*/
	public static $str_key = 'group_56f5752dccdbfacfes';


	public function __construct() {

		add_action( 'init', array( $this, 'acfes_template_block_single_scroll' ) );
	}

	/**
	* Register field group with ACF
	*/
	/**
	* Standard Home/Landing Page Fields
	*/
	public function acfes_template_block_single_scroll( $label = null, array $location = null, $key = null ) {

		if ( is_null( $label ) ) {
			$label = self::$str_label;
		}
		if ( is_null( $location ) ) {
			$location = self::$arr_location;
		}
		if ( is_null( $key ) ) {
			$key = self::$str_key;
		}

		return apply_filters(
			'acfes_template_block_single_scroll_filter',
			array(
				'key'                   => $key,
				'title'                 => $label,
				'fields'                => array(
					$this->acfes_enable_jump_button(),
					$this->acfes_block_single_scroll_page_select(),
				),
				'location'              => array( $location ),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => 1,
				'description'           => '',
			)
		);
	}



} // END class

new Acfes_Block_Field_Groups();
