<?php
/**
* Get Template Part function used within this plugin & templates
*/
if ( ! function_exists( 'acfes_get_block_part' ) ) {

	function acfes_get_block_part( $slug, $name = null ) {

		$templates = new Acfes_Block_Template_Loader;

		$templates->get_template_part( $slug, $name );
	}
}

/**
* Check Block Registry if a block exists
*/
function acfes_check_block_registry( $name ) {
	// return 1 or nothing
	return WP_Block_Type_Registry::get_instance()->is_registered( $name );
}


/**
* Generate Anchor
*/
function acfes_anchor( $str ) {
	return wordwrap( strtolower( $str ), 1, '-', 0 );
}

/**
* Timezone dropdown
*/
function acfes_timezone_dropdown( $default ) {
	return '<select>' . wp_timezone_choice( $default ) . '</select>';
}

/**
* WordPress Timezone
*/
if ( ! function_exists( 'wp_strtotime' ) ) {
	function wp_strtotime( $str ) {
		// This function behaves a bit like PHP's StrToTime() function, but taking into account the WordPress site's timezone
		// CAUTION: It will throw an exception when it receives invalid input - please catch it accordingly
		// From https://mediarealm.com.au/

		$tz_string = get_option( 'timezone_string' );
		$tz_offset = get_option( 'gmt_offset', 0 );

		if ( ! empty( $tz_string ) ) {
				// If site timezone option string exists, use it
				$timezone = $tz_string;

		} elseif ( 0 === $tz_offset ) {
				// get UTC offset, if it isn’t set then return UTC
				$timezone = 'UTC';

		} else {
			$timezone = $tz_offset;

			if ( substr( $tz_offset, 0, 1 ) !== '-' && substr( $tz_offset, 0, 1 ) !== '+' && substr( $tz_offset, 0, 1 ) !== 'U' ) {
					$timezone = '+' . $tz_offset;
			}
		}

		$datetime = new DateTime( $str, new DateTimeZone( $timezone ) );
		return $datetime->format( 'U' );
	}
}

if ( ! function_exists( 'wp_date_localized' ) ) {
	function wp_date_localized( $format = 'U', $timestamp = '' ) {
		// This function behaves a bit like PHP's Date() function, but taking into account the WordPress site's timezone
		// CAUTION: It will throw an exception when it receives invalid input - please catch it accordingly
		// From https://mediarealm.com.au/

		$tz_string = get_option( 'timezone_string' );
		$tz_offset = get_option( 'gmt_offset', 0 );

		if ( $tz ) {
			// A manual timezone
			$timezone = $tz;

		} elseif ( ! empty( $tz_string ) ) {
				// If site timezone option string exists, use it
				$timezone = $tz_string;

		} elseif ( 0 === $tz_offset ) {
				// get UTC offset, if it isn’t set then return UTC
				$timezone = 'UTC';

		} else {
			$timezone = $tz_offset;

			if ( substr( $tz_offset, 0, 1 ) !== '-' && substr( $tz_offset, 0, 1 ) !== '+' && substr( $tz_offset, 0, 1 ) !== 'U' ) {
					$timezone = '+' . $tz_offset;
			}
		}

		if ( null === $timestamp ) {
			$timestamp = time();
		}

		$datetime = new DateTime();
		$datetime->setTimestamp( $timestamp );
		$datetime->setTimezone( new DateTimeZone( $timezone ) );
		return $datetime->format( $format );
	}
}


/**
* Post Type Query
*/
if ( ! function_exists( 'acfes_page_component_post_query' ) ) {
	function acfes_page_component_post_query( $posttype = 'post', $perpage = 3, $acfes_orderby = 'date', $acfes_order = 'DESC', $notin = 'sticky_posts' ) {
			return new WP_Query(
				array(
					'post_type'      => array( $posttype ),
					'post_status'    => 'publish',
					'posts_per_page' => $perpage,
					'orderby'        => $acfes_orderby,
					'order'          => $acfes_order,
					'post__not_in'   => get_option( $notin ),
				)
			);
	}
}

/**
* Post Type Query Paged
*/
if ( ! function_exists( 'acfes_page_component_post_query_paged' ) ) {
	function acfes_page_component_post_query_paged( $posttype = 'post', $perpage = 3, $acfes_orderby = 'date', $acfes_order = 'DESC', $notin = 'sticky_posts', $paged = 1 ) {
			return new WP_Query(
				array(
					'post_type'      => array( $posttype ),
					'post_status'    => 'publish',
					'posts_per_page' => $perpage,
					'orderby'        => $acfes_orderby,
					'order'          => $acfes_order,
					'post__not_in'   => get_option( $notin ),
					'paged'          => $paged,
				)
			);
	}
}


/**
* Taxonomy Query
*/
if ( ! function_exists( 'acfes_page_component_taxonomy_query' ) ) {
	function acfes_page_component_taxonomy_query( $taxonomy, $acfes_terms, $perpage = 3, $acfes_orderby = 'date', $acfes_order = 'DESC' ) {
		return new WP_Query(
			array(
				'posts_per_page' => $perpage,
				'post_status'    => 'publish',
				'orderby'        => $acfes_orderby,
				'order'          => $acfes_order,
				'tax_query'      => array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'slug',
						'terms'    => $acfes_terms,
					),
				),
			)
		);
	}
}

/**
* Taxonomy Query Paged
*/
if ( ! function_exists( 'acfes_page_component_taxonomy_query_paged' ) ) {
	function acfes_page_component_taxonomy_query_paged( $taxonomy, $acfes_terms, $perpage = 3, $acfes_orderby = 'date', $acfes_order = 'DESC', $paged = 1 ) {
			return new WP_Query(
				array(
					'posts_per_page' => $perpage,
					'post_status'    => 'publish',
					'orderby'        => $acfes_orderby,
					'order'          => $acfes_order,
					'tax_query'      => array(
						array(
							'taxonomy' => $taxonomy,
							'field'    => 'slug',
							'terms'    => $acfes_terms,
						),
					),
					'paged'          => $paged,
				)
			);
	}
}
/**
* Meta/Tax query, return orderby title by default
*/
if ( ! function_exists( 'acfes_page_component_meta_tax_title_query' ) ) {
	function acfes_page_component_meta_tax_title_query( $posttype = 'post', $perpage = 3, $acfes_term_field = false, $schedule_date = false, $acfes_orderby = 'title', $acfes_order = 'ASC', $notin = 'sticky_posts' ) {

		$query_args = array(
			'post_type'      => array( $posttype ),
			'post_status'    => 'publish',
			'posts_per_page' => $perpage,
			'orderby'        => $acfes_orderby,
			'order'          => $acfes_order,
			'meta_key'       => 'acfes_session_time',
			'post__not_in'   => get_option( $notin ),
		);

		if ( $acfes_term_field ) {
			$taxonomy    = get_term( $acfes_term_field )->taxonomy;
			$acfes_terms = get_term( $acfes_term_field )->slug;

			$query_args['tax_query'][] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $acfes_terms,
				),
			);
		}

		if ( $schedule_date && strtotime( $schedule_date ) ) {
			$query_args['meta_query'][] = array(
				'key'     => 'acfes_session_time',
				'value'   => array(
					strtotime( $schedule_date ),
					strtotime( $schedule_date . ' +1 day' ),
				),
				'compare' => 'BETWEEN',
				'type'    => 'NUMERIC',
			);
		}

		return new WP_Query( $query_args );
	}
}

/**
* get taxonomy properties from Tax Term ID Field (when term is selected)
*/
if ( ! function_exists( 'acfes_acf_taxonomy_property' ) ) {
	function acfes_acf_taxonomy_property( $property, $fieldname ) {
			$taxid   = get_field( $fieldname );
			$taxterm = get_term( $taxid );
			return $taxterm->$property;
	}
}

/**
* return the slug/path to a taxonomy, as used in a URL, including parents
* @todo it doesn't work if there's a custom rewrite such as in Settings -> Permalinks
* @todo it only works for one level deep (parent) not grandparent, etc
*/
if ( ! function_exists( 'acfes_acf_taxonomy_path' ) ) {
	function acfes_acf_taxonomy_path( $fieldname ) {
		$taxid   = get_field( $fieldname );
		$taxterm = get_term( $taxid );
		$parent  = $taxterm->parent ? get_term( $taxterm->parent ) : false;
		$path    = $parent ? $parent->slug . '/' . $taxterm->slug : $taxterm->slug;
		return $path;
	}
}

/**
* get taxonomy properties from Tax ID Sub-Field (when term is selected)
*/
if ( ! function_exists( 'acfes_acf_taxonomy_sub_property' ) ) {
	function acfes_acf_taxonomy_sub_property( $property, $fieldname ) {
		$taxid   = get_sub_field( $fieldname );
		$taxterm = get_term( $taxid );
		return $taxterm->$property;
	}
}

/**
* return the slug/path to a taxonomy, as used in a URL, including parents
* @todo it doesn't work if there's a custom rewrite such as in Settings -> Permalinks
* @todo it only works for one level deep (parent) not grandparent, etc
*/
if ( ! function_exists( 'acfes_acf_taxonomy_sub_path' ) ) {
	function acfes_acf_taxonomy_sub_path() {
		$taxid   = get_sub_field( $fieldname );
		$taxterm = get_term( $taxid );
		$parent  = $taxterm->parent ? get_term( $taxterm->parent ) : false;
		$path    = $parent ? $parent->slug . '/' . $taxterm->slug : $taxterm->slug;
		return $path;
	}
}

/**
* Taxonomy Query for Archive Field
*/
if ( ! function_exists( 'acfes_taxonomy_query' ) ) {
	function acfes_taxonomy_query( $fieldname, $display = 3, $acfes_orderby = 'date', $acfes_order = 'DESC' ) {

		$taxonomy    = acfes_acf_taxonomy_property( 'taxonomy', $fieldname );
		$acfes_terms = acfes_acf_taxonomy_property( 'slug', $fieldname );

		if ( get_field( 'acfes_archive_taxonomy_number' ) ) {
			$display = get_field( 'acfes_archive_taxonomy_number', $id );
		}

		return acfes_page_component_taxonomy_query( $taxonomy, $acfes_terms, $display, $acfes_orderby, $acfes_order );
	}
}

/**
* Taxonomy Query for Sub Field
*/
if ( ! function_exists( 'acfes_taxonomy_query_sub' ) ) {
	function acfes_taxonomy_query_sub( $fieldname, $display = 3, $acfes_order = 'DESC', $acfes_orderby = 'date' ) {
		$taxonomy    = acfes_acf_taxonomy_sub_property( 'taxonomy', $fieldname );
		$acfes_terms = acfes_acf_taxonomy_sub_property( 'slug', $fieldname );

		if ( get_sub_field( 'acfes_archive_taxonomy_number' ) ) {
			$display = get_sub_field( 'acfes_archive_taxonomy_number' );
		}

		return acfes_page_component_taxonomy_query( $taxonomy, $acfes_terms, $display, $acfes_orderby, $acfes_order );
	}
}

/**
* Taxonomy Query for Sub Field
*/
if ( ! function_exists( 'acfes_taxonomy_query_sub_paged' ) ) {
	function acfes_taxonomy_query_sub_paged( $fieldname, $display = 3, $acfes_order = 'DESC', $acfes_orderby = 'date', $paged ) {
		$taxonomy    = acfes_acf_taxonomy_sub_property( 'taxonomy', $fieldname );
		$acfes_terms = acfes_acf_taxonomy_sub_property( 'slug', $fieldname );

		if ( get_sub_field( 'acfes_archive_taxonomy_number' ) ) {
			$display = get_sub_field( 'acfes_archive_taxonomy_number' );
		}

		return acfes_page_component_taxonomy_query_paged( $taxonomy, $acfes_terms, $display, $acfes_orderby, $acfes_order, $paged );
	}
}

/**
* Term Links From Defined Taxonomy
*/
if ( ! function_exists( 'acfes_terms_from_taxonomy_links' ) ) {
	function acfes_terms_from_taxonomy_links( $tax = '' ) {

		$acfes_terms = get_terms( $tax );

		if ( ! empty( $acfes_terms ) && ! is_wp_error( $acfes_terms ) ) {
			$count           = count( $acfes_terms );
			$i               = 0;
			$acfes_term_list = '<ul class="acfes-component--term-list">';
			foreach ( $acfes_terms as $acfes_term ) {
				$i++;
				$acfes_term_list .= '<li><a href="' . get_term_link( $acfes_term ) . '" title="' . sprintf( __( 'View all filed under %s', 'my_localization_domain' ), $acfes_term->name ) . '" data-id="' . $acfes_term->term_id . '">' . $acfes_term->name . '</a></li>';
				if ( $count !== $i ) {
						$acfes_term_list .= ' ';
				} else {
						$acfes_term_list .= '</ul>';
				}
			}
			echo wp_kses_post( $acfes_term_list );
		}
	}
}


/**
* Outputs the color class (background or regular) from a given color field
*/
if ( ! function_exists( 'acfes_color_picker_class' ) ) {
	function acfes_color_picker_class( $color_field = '', $sub = false, $background = false ) {
		// Get ACF Values from color picker
		$mtm_acf_color_picker_values = $sub ? get_sub_field( $color_field ) : get_field( $color_field );

		// Set array of color classes (for block editor) and hex codes (from ACF)
		$mtm_block_colors = apply_filters(
			'mtm_block_colors_filter',
			array(
				// Change these to match your color class (gutenberg) and hex codes (acf)
				'brand-color-1'    => '#96CA4C',
				'brand-color-2'    => '#C95014',
				'brand-color-3'    => '#2191c7',
				'brand-color-4'    => '#206582',
				'brand-color-5'    => '#6B299B',
				'brand-links'      => '#368715',
				'brand-alert'      => '#E6135A',
				'white'            => '#ffffff',
				'neutral-lightest' => '#f6f6f6',
				'neutral-light'    => '#e0e0e0',
				'neutral-mid'      => '#949494',
				'neutral-dark'     => '#636363',
				'neutral-darkest'  => '#212121',
			)
		);
		$mtm_color_class = null;

		if ( $mtm_acf_color_picker_values ) {
			// Loop over colors array and set proper class if background color selection matches value
			foreach ( $mtm_block_colors as $key => $value ) {
				if ( $mtm_acf_color_picker_values === $value ) {
						$mtm_color_class = $key;
				}
			}
		}
		if ( $mtm_color_class ) {
			$mtm_color_class_output = $background ? 'has-custom-background-color has-' . $mtm_color_class . '-background-color' : 'has-custom-color has-' . $mtm_color_class . '-color';
		} elseif ( $mtm_acf_color_picker_values ) {
			$mtm_color_class_output = $background ? 'has-custom-background-color' : 'has-custom-color';
		} else {
			$mtm_color_class_output = $background ? 'has-no-background-color' : 'has-no-color';
		}
		return $mtm_color_class_output;
	}
}



/**
* Add count class
*/
if ( ! function_exists( 'acfes_count_classes' ) ) {
	function acfes_count_classes( $count = 1 ) {
		$item_count   = $count;
		$item_classes = '';

		if ( 6 === $item_count || $item_count >= 11 ) :
			// Six items per row if there's six or greater/equal to 10 items
			$item_classes = 'acfes-per-row-6';
		elseif ( 5 === $item_count || 10 === $item_count ) :
			// Three items per row if there's 5 or 8 items
			$item_classes = 'acfes-per-row-5';
		elseif ( 4 === $item_count || $item_count >= 7 && $item_count <= 8 ) :
			// Four items per row if there's 4, 7, or 8 items
			$item_classes = 'acfes-per-row-4';
		elseif ( 3 === $item_count || 9 === $item_count ) :
			// Three items per row if there's three or nine items
			$item_classes = 'acfes-per-row-3';
		elseif ( 2 === $item_count ) :
			// Otherwise show two widgets per row
			$item_classes = 'acfes-per-row-2';
		endif;
		return $item_classes;
	}
}

/**
* Output a per-row class based on how many admin picked
*/
if ( ! function_exists( 'acfes_output_row_number' ) ) {
	function acfes_output_row_number( $field = 'acfes_number_per_row', $num = 3 ) {

		if ( get_sub_field( $field ) ) {

			$num = get_sub_field( $field );

		} elseif ( get_field( $field ) ) {

			$num = get_field( $field );
		}

		return 'acfes-per-row-' . $num;
	}
}



/*
* Output file from custom field
*/
if ( ! function_exists( 'acfes_output_file_link' ) ) {
	function acfes_output_file_link( $file_field = '', $label_field = '', $prefix = 'fal fa-file fa-file', $showsize = true ) {
		$file      = $file_field;
		$text      = $label_field ? $label_field . ' ' . $file['title'] : $file['title'];
		$mime      = wp_check_filetype( $file['filename'] )['ext'] ? '-' . wp_check_filetype( $file['filename'] )['ext'] : '';
		$file_type = $prefix . $mime;
		$path_info = pathinfo( $file['url'] );
		$filesize  = $showsize ? wp_prepare_attachment_for_js( $file['id'] )['filesizeHumanReadable'] . ' ' : '';

		echo '<span class="file-downloads"><i class="' . esc_attr( $file_type ) . '"></i> <a aria-label="Download ' . esc_html( $file['title'] ) . ' ' . esc_html( strtoupper( $path_info['extension'] ) ) . '" href="' . esc_url( $file['url'] ) . '">' . esc_html( $text ) . ' (' . esc_html( $filesize ) . esc_html( $path_info['extension'] ) . ') </a></span>';
	}
}

/**
* Check if user has any posts in any post type
* $acfes_post_types must be an array
*/
if ( ! function_exists( 'acfes_check_all_user_posts' ) ) {
	function acfes_check_all_user_posts( $userid = '', $acfes_post_types = array( 'post' ) ) {
		$count = 0;
		foreach ( $acfes_post_types as $type ) {
			$count += count_user_posts( $userid, $type );
		}
		return $count;
	}
}

/**
* Return Post Object URL List
*/
function acfes_get_post_object_url_list( $post_objects ) {
	if ( $post_objects ) {
		$num_items = count( $post_objects ); // how many terms are there
		$i         = 0;

		$open  = '<div class="url-list">';
		$out[] = '<ul>';
		foreach ( $post_objects as $post_object ) {
			if ( ++$i === $num_items ) { // if this is the last one
				$out[] = sprintf(
					'<li><a aria-label="Speaker %2$s" href="%1$s" >%2$s</a></li></ul>',
					esc_url( get_permalink( $post_object->ID ) ),
					get_the_title( $post_object->ID )
				);
			} else {
				$out[] = sprintf(
					'<li><a aria-label="Speaker %2$s" href="%1$s" >%2$s</a></li>',
					esc_url( get_permalink( $post_object->ID ) ),
					get_the_title( $post_object->ID )
				);
			}
		}
		$close = "</ul></div>\n";
		return $open . implode( '', $out ) . $close;
	}
}

/**
* Return Post Object Anchor List
*/

function acfes_get_post_object_anchor_list( $post_objects ) {
	if ( $post_objects ) {
		$num_items = count( $post_objects ); // how many terms are there
		$i         = 0;

		$open  = '<div class="url-list">';
		$out[] = '<ul>';
		foreach ( $post_objects as $post_object ) {
			if ( ++$i === $num_items ) { // if this is the last one
				$out[] = sprintf(
					'<li><a aria-label="Speaker %2$s" href="#%1$s" >%2$s</a></li></ul>',
					esc_html( acfes_anchor( get_the_title( $post_object->ID ) ) ),
					get_the_title( $post_object->ID )
				);
			} else {
				$out[] = sprintf(
					'<li><a aria-label="Speaker %2$s" href="#%1$s" >%2$s</a></li>',
					esc_html( acfes_anchor( get_the_title( $post_object->ID ) ) ),
					get_the_title( $post_object->ID )
				);
			}
		}
		$close = "</ul></div>\n";
		return $open . implode( '', $out ) . $close;
	}
}


/**
 * Return an unordered list of linked social media icons, based on the urls provided in the Customizer Sortable Repeater
 * This is a sample function to display some social icons on your site.
 * This sample function is also used to show how you can call a PHP function to refresh the customizer preview.
 * Add the following code to header.php if you want to see the sample social icons displayed in the customizer preview and your theme.
 * Before any social icons display, you'll also need to add the relevent URL's to the Header Navigation > Social Icons section in the Customizer.
 * <div class="social">
 * <?php echo acfes_get_social_media(); ?>
 * </div>
 *
 * @return string Unordered list of linked social media icons
 */
if ( ! function_exists( 'acfes_get_social_media' ) ) {
	function acfes_get_social_media() {
		$defaults      = acfes_generate_defaults();
		$output        = array();
		$social_icons  = acfes_generate_social_urls();
		$social_urls   = explode( ',', get_theme_mod( 'social_urls', $defaults['social_urls'] ) );
		$social_newtab = get_theme_mod( 'social_newtab', $defaults['social_newtab'] );

		foreach ( $social_urls as $key => $value ) {
			if ( ! empty( $value ) ) {
				$domain = str_ireplace( 'www.', '', wp_parse_url( $value, PHP_URL_HOST ) );
				$index  = array_search( strtolower( $domain ), array_column( $social_icons, 'url' ), true );
				if ( false !== $index ) {
					$output[] = sprintf(
						'<a class="button button-social %1$s %5$s" href="%2$s" title="%3$s"%4$s aria-label="%3$s"></a>',
						$social_icons[ $index ]['class'],
						esc_url( $value ),
						$social_icons[ $index ]['title'],
						( ! $social_newtab ? '' : ' target="_blank"' ),
						$social_icons[ $index ]['icon']
					);
				} else {
					$output[] = sprintf(
						'<a class="button button-social nosocial %4$s" href="%2$s"%3$s></a>',
						$social_icons[ $index ]['class'],
						esc_url( $value ),
						( ! $social_newtab ? '' : ' target="_blank"' ),
						'fas fa-globe'
					);
				}
			}
		}

		if ( ! empty( $output ) ) {
			$output = apply_filters( 'acfes_social_icons_list', $output );
			array_unshift( $output, '<nav class="social-icons" aria-label-"Social Networks">' );
			$output[] = '</nav>';
		}

		return implode( '', $output );
	}
}
/**
* Social Icons
*/
function get_acfes_social_icons( $fieldname = '', $id = null ) {
	if ( get_field( $fieldname, $id ) ) {

		$output       = array();
		$social_icons = acfes_generate_social_urls();

		if ( have_rows( $fieldname, $id ) ) {

			while ( have_rows( $fieldname, $id ) ) {
				the_row(); // Loop through each item

				$value = get_sub_field( 'acfes_social_url', $id );

				if ( ! empty( $value ) ) {
					$domain = str_ireplace( 'www.', '', wp_parse_url( $value, PHP_URL_HOST ) );
					$index  = array_search( strtolower( $domain ), array_column( $social_icons, 'url' ), true );

					if ( false !== $index ) {
						$output[] = sprintf(
							'<a class="button button-social %1$s %4$s" href="%2$s" title="%3$s" aria-label="%3$s"></a>',
							$social_icons[ $index ]['class'],
							esc_url( $value ),
							$social_icons[ $index ]['title'],
							$social_icons[ $index ]['icon']
						);
					} else {
						$output[] = sprintf(
							'<a class="button button-social nosocial %4$s" href="%2$s"%3$s></a>',
							$social_icons[ $index ]['class'],
							esc_url( $value ),
							( ! $social_newtab ? '' : ' target="_blank"' ),
							'fas fa-globe'
						);
					}
				} // end if value
			} // end while have rows
			if ( ! empty( $output ) ) {
				$output = apply_filters( 'acfes_social_icons_list', $output );
				array_unshift( $output, '<span class="social-icons"><nav class="social-icons--nav" aria-label="Social Media Links">' );
				$output[] = '</nav></span>';
			}
		} // end if have rows
		return implode( '', $output );
	} // end if get field
}

/**
* Web Links
*/
function the_acfes_web_links( $fieldname = '', $id = null, $label_field = '', $prefix = 'fal fa-file fa-file', $showsize = true ) {
	if ( get_field( $fieldname, $id ) ) :
		if ( have_rows( $fieldname, $id ) ) : ?>

			<span class="links">
				<nav class="social-icons--nav list-nav" aria-label="Web Links">

				<?php
				while ( have_rows( $fieldname, $id ) ) :
					the_row(); // Loop through each item

					$link = get_sub_field( 'acfes_link', $id );
					?>

					<a aria-label="<?php echo esc_html( $link['title'] ); ?>" href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ); ?>"><?php echo esc_html( $link['title'] ); ?></a>

				<?php endwhile; ?>
				</nav>
			</span>

			<?php
		endif; // End ACF Repeater Field
	endif;
}

/**
* Multiple Files
*/
function the_acfes_file_links( $fieldname = '', $id = null ) {
	if ( get_field( $fieldname, $id ) ) :
		if ( have_rows( $fieldname, $id ) ) :
			?>
			<span class="files">
				<nav class="social-icons--nav list-nav" aria-label="File Download Links">
					<?php
					while ( have_rows( $fieldname, $id ) ) :
						the_row(); // Loop through each item

							$filefield = get_sub_field( 'acfes_post_uploaded_file', $id );
							acfes_output_file_link( $filefield );

					endwhile;
					?>
				</nav>
			</span>

			<?php
		endif; // End ACF Repeater Field
	endif;
}


/**
* Return Post Object With Image List
*/

function acfes_get_post_object_image_list( $post_objects ) {
	if ( $post_objects ) {

		$open  = '<div class="url-image-list">';
		$out[] = '';
		foreach ( $post_objects as $post_object ) {
			$out[] = sprintf(
				'<div class="url-image-list--item"><figure class="post--thumbnail acfes-post-thumbnail" style="background-image:url(%3$s)"></figure><a aria-label="Speaker %2$s" href="%1$s" >%2$s</a></div>',
				esc_url( get_permalink( $post_object->ID ) ),
				get_the_title( $post_object->ID ),
				get_the_post_thumbnail_url( $post_object->ID )
			);
		}
		$close = "</div>\n";
		return $open . implode( '', $out ) . $close;
	}
}


/**
* Upcoming Events
*/

function acfes_upcoming_events( $start_time = '', $end_time = '', $acfes_term = '', $number = 1 ) {

	$query_args = array(
		'post_type'      => 'acfes_session',
		'post_status'    => 'publish',
		'posts_per_page' => $number,
		'meta_key'       => 'acfes_session_time',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'key'     => 'acfes_session_time',
				'compare' => 'EXISTS',
			),
		),
	);
	if ( ( $start_time && strtotime( $start_time ) ) && ( $end_time && strtotime( $end_time ) ) ) {
		$query_args['meta_query'][] = array(
			'key'     => 'acfes_session_time',
			'value'   => array(
				strtotime( $start_time ),
				strtotime( $end_time ),
			),
			'compare' => 'BETWEEN',
			'type'    => 'NUMERIC',
		);
	}
	if ( $acfes_term ) {
		$query_args['tax_query'][] = array(
			'taxonomy' => get_term( $acfes_term )->taxonomy,
			'field'    => 'slug',
			'terms'    => get_term( $acfes_term )->slug,
		);
	}

	return new WP_Query( $query_args );
}

/**
* Current Events
*/
function acfes_current_event( $start_time = '', $now = '', $acfes_term = '' ) {

	$query_args = array(
		'post_type'      => 'acfes_session',
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'meta_key'       => 'acfes_session_time',
		'orderby'        => 'meta_value_num',
		'order'          => 'DESC',
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'key'     => 'acfes_session_time',
				'compare' => 'EXISTS',
			),
		),
	);
	if ( ( $start_time && strtotime( $start_time ) ) && ( $now && strtotime( $now ) ) ) {
		$query_args['meta_query'][] = array(
			'key'     => 'acfes_session_time',
			'value'   => array(
				strtotime( $start_time ),
				strtotime( $now ),
			),
			'compare' => 'BETWEEN',
			'type'    => 'NUMERIC',
		);
	}
	if ( $acfes_term ) {
		$query_args['tax_query'][] = array(
			'taxonomy' => get_term( $acfes_term )->taxonomy,
			'field'    => 'slug',
			'terms'    => get_term( $acfes_term )->slug,
		);
	}

	return new WP_Query( $query_args );
}

/**
* Outputs the post thumbnail with fallback for the default image
*/
if ( ! function_exists( 'the_acfes_post_thumbnail_cropped' ) ) {
	function the_acfes_post_thumbnail_cropped( $size = 'full', $class = '', $link = true, $attr = '' ) {
		$link_open  = $link ? '<a aria-hidden="true" tabindex="-1" href="' . get_the_permalink() . '">' : '';
		$link_close = $link ? '</a>' : '';
		if ( has_post_thumbnail() ) :
			echo wp_kses_post( $link_open ) . '<figure class="post--thumbnail has-background-image cropped ' . esc_attr( $class ) . '" style="background-image:url(' . esc_url( get_the_post_thumbnail_url( $post, $size ) ) . ')"></figure>' . wp_kses_post( $link_close );
		elseif ( get_theme_mod( 'mtm_default_image' ) ) : // make sure field value exists
			$image = get_theme_mod( 'mtm_default_image' );
			$url   = wp_get_attachment_image_src( $image, $size )[0];
			$alt   = '';
			echo wp_kses_post( $link_open ) . '<figure class="post--thumbnail default-thumbnail has-background-image cropped ' . esc_attr( $class ) . '" style="background-image:url(' . esc_url( $url ) . '"></figure>' . wp_kses_post( $link_close );
		endif;
	}
}
