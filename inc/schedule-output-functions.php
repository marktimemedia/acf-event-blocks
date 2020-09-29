<?php

/**
 * Schedule block functions.
 */

defined( 'WPINC' ) || die();

/**
* The Main query
*/
function acfes_session_query( $schedule_date, $tracks_explicitly_specified, $tracks ) {
	if ( $schedule_date && strtotime( $schedule_date ) ) {
		$query_args = array(
			'post_type'      => 'acfes_session',
			'posts_per_page' => - 1,
			'order'          => 'ASC',
			'orderby'        => 'meta_value_num',
			'meta_key'       => 'acfes_session_time',
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => 'acfes_session_time',
					'compare' => 'EXISTS',
				),
				array(
					'key'     => 'acfes_session_time',
					'value'   => array(
						strtotime( $schedule_date ),
						strtotime( $schedule_date . ' +1 day' ),
					),
					'compare' => 'BETWEEN',
					'type'    => 'NUMERIC',
				),
			),
		);
	}
	if ( $tracks_explicitly_specified ) {
		// If tracks were provided, restrict the lookup in WP_Query.
		if ( ! empty( $tracks ) ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'acfes_track',
				'field'    => 'id',
				'terms'    => array_values( wp_list_pluck( $tracks, 'term_id' ) ),
			);
		}
	}
	return new WP_Query( $query_args );
}

/**
 * Return an associative array of term_id -> term object mapping for all selected tracks.
 *
 * In case of 'all' is used as a value for $selected_tracks, information for all available tracks
 * gets returned.
 *
 * @param string $selected_tracks Comma-separated list of tracks to display or 'all'.
 *
 * @return array Associative array of terms with term_id as the key.
 */
function acfes_get_schedule_tracks( $selected_tracks ) {
	$tracks = array();
	if ( 'all' === $selected_tracks ) {
		// Include all tracks.
		$tracks = get_terms( 'acfes_track' );
	} else {
		// Loop through given tracks and look for terms.
		$acfes_terms = array_map( 'trim', explode( ',', $selected_tracks ) );

		foreach ( $acfes_terms as $acfes_term_slug ) {
			$acfes_term = get_term_by( 'slug', $acfes_term_slug, 'acfes_track' );
			if ( $acfes_term ) {
				$tracks[ $acfes_term->term_id ] = $acfes_term;
			}
		}
	}

	return $tracks;
}

/**
 * Return a time-sorted associative array mapping timestamp -> track_id -> session id.
 *
 * @param string $schedule_date               Date for which the sessions should be retrieved.
 * @param bool   $tracks_explicitly_specified True if tracks were explicitly specified in the shortcode,
 *                                            false otherwise.
 * @param array  $tracks                      Array of terms for tracks from acfes_get_schedule_tracks().
 *
 * @return array Associative array of session ids by time and track.
 */

function acfes_get_schedule_sessions( $schedule_date, $tracks_explicitly_specified, $tracks ) {

	// Loop through all sessions and assign them into the formatted
	// $sessions array: $sessions[ $time ][ $track ] = $session_id
	// Use 0 as the track ID if no tracks exist.
	$sessions       = array();
	$sessions_query = acfes_session_query( $schedule_date, $tracks_explicitly_specified, $tracks );

	if ( $sessions_query->post_count > 0 ) {
		foreach ( $sessions_query->posts as $session ) {
			$time        = get_post_meta( $session->ID, 'acfes_session_time' )[0];
			$acfes_terms = get_the_terms( $session->ID, 'acfes_track' );

			if ( ! isset( $sessions[ $time ] ) ) {
				$sessions[ $time ] = array();
			}

			if ( empty( $acfes_terms ) ) {
				$sessions[ $time ][0] = $session->ID;
			} else {
				foreach ( $acfes_terms as $track ) {
					$sessions[ $time ][ $track->term_id ] = $session->ID;
				}
			}
		}
		// Sort all sessions by their key (timestamp).
		ksort( $sessions );
	}

	return $sessions;
}

/**
 * Return an array of columns identified by term ids to be used for schedule table.
 *
 * @param array $tracks                      Array of terms for tracks from acfes_get_schedule_tracks().
 * @param array $sessions                    Array of sessions from acfes_get_schedule_sessions().
 * @param bool  $tracks_explicitly_specified True if tracks were explicitly specified in the shortcode,
 *                                           false otherwise.
 *
 * @return array Array of columns identified by term ids.
 */
function acfes_get_schedule_columns( $tracks, $sessions, $tracks_explicitly_specified ) {
	$columns = array();

	// Use tracks to form the columns.
	if ( $tracks ) {
		foreach ( $tracks as $track ) {
			$columns[ $track->term_id ] = $track->term_id;
		}
	} else {
		$columns[0] = 0;
	}

	// Remove empty columns unless tracks have been explicitly specified.
	if ( ! $tracks_explicitly_specified ) {
		$used_terms = array();

		foreach ( $sessions as $time => $entry ) {
			if ( is_array( $entry ) ) {
				foreach ( $entry as $acfes_term_id => $session_id ) {
					$used_terms[ $acfes_term_id ] = $acfes_term_id;
				}
			}
		}

		$columns = array_intersect( $columns, $used_terms );
		unset( $used_terms );
	}

	return $columns;
}

/**
 * Update and preprocess input attributes for [schedule] shortcode.
 *
 * @param array $attr Array of attributes from shortcode.
 *
 * @return array Array of attributes, after preprocessing.
 */
function acfes_preprocess_schedule_attributes( $props ) {

	// Set Defaults
	$attr = array(
		'date'            => null,
		'tracks'          => 'all',
		'session_link'    => 'permalink', // permalink|anchor|none
		'speaker_link'    => 'permalink', // permalink|anchor|none
		'color_scheme'    => 'light', // light/dark
		'schedule_layout' => 'table',
		'align'           => '', // alignwide|alignfull
	);

	// Check if props exist. Fixes PHP errors when shortcode doesn't have any attributes.
	if ( $props ) :

		// Set Attribute values base on props
		if ( $props['date'] ) {
			$attr['date'] = $props['date'];
		}

		if ( $props['color_scheme'] ) {
			$attr['color_scheme'] = $props['color_scheme'];
		}

		if ( $props['schedule_layout'] ) {
			$attr['schedule_layout'] = $props['schedule_layout'];
		}

		if ( $props['session_link'] ) {
			$attr['session_link'] = $props['session_link'];
		}

		if ( $props['speaker_link'] ) {
			$attr['speaker_link'] = $props['speaker_link'];
		}

		if ( 'wide' === $props['align'] ) {
			$attr['align'] = 'alignwide';
		} elseif ( 'full' === $props['align'] ) {
			$attr['align'] = 'alignfull';
		}

		if ( $props['tracks'] ) {
			$attr['tracks'] = $props['tracks'];
		}

		foreach ( array( 'tracks', 'session_link', 'speaker_link', 'color_scheme' ) as $key_for_case_sensitive_value ) {
			$attr[ $key_for_case_sensitive_value ] = strtolower( $attr[ $key_for_case_sensitive_value ] );
		}

		if ( ! in_array( $attr['session_link'], array( 'permalink', 'anchor', 'none' ) ) ) {
			$attr['session_link'] = 'permalink';
		}
		if ( ! in_array( $attr['speaker_link'], array( 'permalink', 'anchor', 'none' ) ) ) {
			$attr['speaker_link'] = 'permalink';
		}

	endif;

	// var_dump($props);

	return $attr;
}

/**
 * Schedule Block and Shortcode Dynamic content Output.
 *
 * @param array $attr Array of attributes from shortcode.
 *
 * @return array Array of attributes, after preprocessing.
 */
function acfes_schedule_output( $props ) {

	$attr                        = acfes_preprocess_schedule_attributes( $props );
	$tracks                      = acfes_get_schedule_tracks( $attr['tracks'] );
	$tracks_explicitly_specified = 'all' !== $attr['tracks'];
	$sessions                    = acfes_get_schedule_sessions( $attr['date'], $tracks_explicitly_specified, $tracks );
	$columns                     = acfes_get_schedule_columns( $tracks, $sessions, $tracks_explicitly_specified );
	$rand                        = wp_rand( 1, 100 );

	// Table Layout
	if ( 'table' === $attr['schedule_layout'] && $sessions ) {

		$html  = '<div class="acfes-schedule-wrapper ' . $attr['align'] . '">';
		$html .= '<table class="acfes-schedule acfes-color-scheme-' . $attr['color_scheme'] . ' acfes-layout-' . $attr['schedule_layout'] . '" border="0">';
		$html .= '<thead>';
		$html .= '<tr>';

		// Table headings.
		$html .= '<th class="acfes-col-time">' . esc_html__( 'Time', 'acf-event-schedule' ) . '</th>';
		foreach ( $columns as $acfes_term_id ) {
			$track = get_term( $acfes_term_id, 'acfes_track' );
			$html .= sprintf(
				'<th class="acfes-col-track"> <span class="acfes-track-name">%s</span> <span class="acfes-track-description">%s</span> </th>',
				isset( $track->term_id ) ? esc_html( $track->name ) : '',
				isset( $track->term_id ) ? esc_html( $track->description ) : ''
			);
		}

		$html .= '</tr>';
		$html .= '</thead>';

		$html .= '<tbody>';

		$time_format = get_option( 'time_format', 'g:i a' );

		foreach ( $sessions as $time => $entry ) {

			$skip_next = $colspan = 0;

			$columns_html = '';
			foreach ( $columns as $key => $acfes_term_id ) {

				// Allow the below to skip some items if needed.
				if ( $skip_next > 0 ) {
					$skip_next--;
					continue;
				}

				// For empty items print empty cells.
				if ( empty( $entry[ $acfes_term_id ] ) ) {
					$columns_html .= '<td class="acfes-session-empty"></td>';
					continue;
				}

				// For custom labels print label and continue.
				if ( is_string( $entry[ $acfes_term_id ] ) ) {
					$columns_html .= sprintf( '<td colspan="%d" class="acfes-session-custom">%s</td>', count( $columns ), esc_html( $entry[ $acfes_term_id ] ) );
					break;
				}

				// Gather relevant data about the session
				$colspan              = 1;
				$classes              = array();
				$session              = get_post( $entry[ $acfes_term_id ] );
				$session_title        = apply_filters( 'the_title', $session->post_title );
				$session_tracks       = get_the_terms( $session->ID, 'acfes_track' );
				$session_track_titles = is_array( $session_tracks ) ? implode( ', ', wp_list_pluck( $session_tracks, 'name' ) ) : '';
				$session_type         = get_field( 'acfes_session_type', $session->ID );
				$break_link           = get_field( 'acfes_break_link', $session->ID );
				$session_scheduled    = get_field( 'acfes_scheduled_session', $session->ID );
				$speakers             = get_field( 'acfes_session_speakers', $session->ID );

				if ( ! $session_scheduled ) {
					continue; // ignore if it shouldn't go on this grid
				}

				if ( ! in_array( $session_type, array( 'session', 'custom', 'mainstage', 'special' ), true ) ) {
					$session_type = 'session';
				}

				// Add CSS classes to help with custom styles
				if ( is_array( $session_tracks ) ) {
					foreach ( $session_tracks as $session_track ) {
						$classes[] = 'acfes-track-' . $session_track->slug;
					}
				}

				$classes[] = 'acfes-session-type-' . $session_type;
				$classes[] = 'acfes-session-' . $session->post_name;

				$content  = '';
				$content .= '<div class="acfes-session-cell-content">';

				// Determine the session title
				if ( 'permalink' === $attr['session_link'] && ( 'custom' !== $session_type || 1 === $break_link ) ) {
					$session_title_html = sprintf( '<h3><a class="acfes-session-title" href="%s">%s</a></h3>', esc_url( get_permalink( $session->ID ) ), $session_title );
				} elseif ( 'anchor' === $attr['session_link'] && ( 'custom' !== $session_type || 1 === $break_link ) ) {
					$session_title_html = sprintf( '<h3><a class="acfes-session-title" href="%s">%s</a></h3>', esc_url( '#' . get_post_field( 'post_name', $session->ID ) ), $session_title );
				} else {
					$session_title_html = sprintf( '<h3><span class="acfes-session-title">%s</span></h3>', $session_title );
				}

				$content .= $session_title_html;

				// Add speakers names to the output string.
				if ( $speakers ) {
					if ( 'anchor' === $attr['speaker_link'] ) {
						$content .= '<span class="acfes-session-speakers">' . acfes_get_post_object_anchor_list( $speakers ) . '</span>';
					} elseif ( 'permalink' === $attr['speaker_link'] ) {
						$content .= '<span class="acfes-session-speakers">' . acfes_get_post_object_url_list( $speakers ) . '</span>';
					}
				}

				if ( function_exists( 'get_favorites_button' ) ) {
					$content .= get_favorites_button( $session->ID );
				}

				// Session Content Footer Filter
				$acfes_session_content_footer = apply_filters( 'acfes_session_content_footer', $session->ID );
				$content                     .= ( $acfes_session_content_footer !== $session->ID ) ? $acfes_session_content_footer : '';

				// End of cell-content.
				$content .= '</div>';

				$columns_clone = $columns;

				// If the next element in the table is the same as the current one, use colspan
				if ( $key !== key( array_slice( $columns, -1, 1, true ) ) ) {
					while ( $pair = each( $columns_clone ) ) {
						if ( $pair['key'] === $key ) {
							continue;
						}

						if ( ! empty( $entry[ $pair['value'] ] ) && $entry[ $pair['value'] ] === $session->ID ) {
							$colspan++;
							$skip_next++;
						} else {
							break;
						}
					}
				}

				$columns_html .= sprintf( '<td colspan="%d" class="%s" data-track-title="%s" data-session-id="%s">%s</td>', $colspan, esc_attr( implode( ' ', $classes ) ), $session_track_titles, esc_attr( $session->ID ), $content );
			}

			$global_session      = $colspan == count( $columns ) ? ' acfes-global-session'.' acfes-global-session-'.esc_html($session_type) : '';
			$global_session_slug = $global_session ? ' ' . sanitize_html_class( sanitize_title_with_dashes( $session->post_title ) ) : '';

			$html .= sprintf( '<tr class="%s">', sanitize_html_class( 'acfes-time-' . gmdate( $time_format, $time ) ) . $global_session . $global_session_slug );
			$html .= sprintf( '<td class="acfes-time">%s</td>', str_replace( ' ', '&nbsp;', esc_html( gmdate( $time_format, $time ) ) ) );
			$html .= $columns_html;
			$html .= '</tr>';
		}

		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';
		return $html;

		// GRID LAYOUT
	} elseif ( 'grid' === $attr['schedule_layout'] && $sessions ) {

		$schedule_date = $attr['date'];
		$time_format   = get_option( 'time_format', 'g:i a' );
		$columns       = acfes_get_schedule_columns( $tracks, $sessions, $tracks_explicitly_specified );

		$sessions_query = acfes_session_query( $schedule_date, $tracks_explicitly_specified, $tracks );

		$array_times = array();
		foreach ( $sessions_query->posts as $session ) {
			$time        = strtotime( get_field( 'acfes_session_time', $session->ID ) );
			$end_time    = strtotime( get_field( 'acfes_session_end_time', $session->ID ) );
			$acfes_terms = get_the_terms( $session->ID, 'acfes_track' );

			if ( ! in_array( $end_time, $array_times, true ) ) {
				array_push( $array_times, $end_time );
			}

			if ( ! in_array( $time, $array_times, true ) ) {
				array_push( $array_times, $time );
			}
		}
		asort( $array_times );
		// Reset PHP Array Index
		$array_times = array_values( $array_times );
		// Remove last time item
		unset( $array_times[ count( $array_times ) - 1 ] );

		$html .= '<style>
		@media screen and (min-width:48.75em) {
		.acfes-layout-grid.grid-' . $rand . ' {
			display: grid;
			grid-gap: 1em;
			grid-template-rows:
			[tracks] auto';

		foreach ( $array_times as $array_time ) {
			$html .= '[time-' . $array_time . '] 1fr';
		}

		$html .= ';';

		$html .= 'grid-template-columns: [times] 4em';

		// Reset PHP Array Index
		$total_tracks = array_values( $tracks );
		$tracks = [];

		// check to make sure the tracks are actually in use at all in this query
		foreach ( $total_tracks as $track ) {
			if ( in_array( $track->term_id, $columns, true ) ) {
				$tracks[] = $track;
			}
		}

		$len = count( $tracks );

		// Check the above var dump for issue
		for ( $i = 0; $i < ( $len ); $i++ ) {
			if ( 0 === $i ) {
				$html .= '[' . $tracks[ $i ]->slug . '-start] 1fr';
			} elseif ( ( $len - 1 ) === $i ) {
				$html .= '[' . $tracks[ ( $i - 1 ) ]->slug . '-end ' . $tracks[ $i ]->slug . '-start] 1fr';
				$html .= '[' . $tracks[ $i ]->slug . '-end];';
			} else {
				$html .= '[' . $tracks[ ( $i - 1 ) ]->slug . '-end ' . $tracks[ $i ]->slug . '-start] 1fr';
			}
		}

		$html .= ';';

		$html .= '
		}
	}
	</style>';

		// Schedule Wrapper
		$html .= '<div class="schedule acfes-schedule acfes-color-scheme-' . $attr['color_scheme'] . ' acfes-layout-' . $attr['schedule_layout'] . ' grid-' . $rand . '" aria-labelledby="schedule-heading">';

		// Track Titles
		if ( $tracks ) {
			foreach ( $tracks as $track ) {
				$html .= sprintf(
					'<span class="acfes-col-track" style="grid-column: ' . $track->slug . '; grid-row: tracks;"> <span class="acfes-track-name">%s</span> <span class="acfes-track-description">%s</span> </span>',
					isset( $track->term_id ) ? esc_html( $track->name ) : '',
					isset( $track->term_id ) ? esc_html( $track->description ) : ''
				);
			}
		}

		// Time Slots
		if ( $array_times ) {
			foreach ( $array_times as $array_time ) {
				$html .= '<h2 class="acfes-time" style="grid-row: time-' . $array_time . ';">' . gmdate( $time_format, $array_time ) . '</h2>';
			}
		}

		foreach ( $sessions_query->posts as $session ) {
			$classes              = array();
			$session              = get_post( $session );
			$session_url          = get_the_permalink( $session->ID );
			$session_title        = apply_filters( 'the_title', $session->post_title );
			$session_tracks       = get_the_terms( $session->ID, 'acfes_track' );
			$session_track_titles = is_array( $session_tracks ) ? implode( ', ', wp_list_pluck( $session_tracks, 'name' ) ) : '';
			$session_scheduled    = get_field( 'acfes_scheduled_session', $session->ID );
			$session_type         = get_field( 'acfes_session_type', $session->ID );
			$speakers             = get_field( 'acfes_session_speakers', $session->ID );
			$break_link           = get_field( 'acfes_break_link', $session->ID );
			$start_time           = strtotime( get_field( 'acfes_session_time', $session->ID ) );
			$end_time             = strtotime( get_field( 'acfes_session_end_time', $session->ID ) );

			if ( ! $session_scheduled ) {
				continue; // ignore if it shouldn't go on this grid
			}

			if ( ! in_array( $session_type, array( 'session', 'custom', 'mainstage', 'special' ), true ) ) {
				$session_type = 'session';
			}

			$tracks_array       = array();
			$tracks_names_array = array();
			if ( $session_tracks ) {
				foreach ( $session_tracks as $session_track ) {

					// Check if the session track is in the main tracks array.
					if ( $track ) {
						$remove_track = false;
						foreach ( $tracks as $track ) {
							if ( $track->slug == $session_track->slug ) {
								$remove_track = true;
							}
						}
					}

					// Don't save session track if track doesn't exist.
					if ( $remove_track == true ) {
						$tracks_array . array_push( $tracks_array, $session_track->slug );
						$tracks_names_array . array_push( $tracks_names_array, $session_track->name );
					}
				}
			}
			$tracks_classes = implode( ' ', $tracks_array );

			// Add CSS classes to help with custom styles
			if ( is_array( $session_tracks ) ) {
				foreach ( $session_tracks as $session_track ) {
					$classes[] = 'acfes-track-' . $session_track->slug;
				}
			}
			$classes[] = 'acfes-session-type-' . $session_type;
			$classes[] = 'acfes-session-' . $session->post_name;

			$tracks_array_length = esc_attr( count( $tracks_array ) );

			$grid_column_end = '';
			if ( 1 !== $tracks_array_length ) {
				$grid_column_end = ' / ' . $tracks_array[ $tracks_array_length - 1 ];
			}

			$html .= '<div class="' . esc_attr( implode( ' ', $classes ) ) . ' ' . $tracks_classes . '" style="grid-column: ' . $tracks_array[0] . $grid_column_end . '; grid-row: time-' . $start_time . ' / time-' . $end_time . ';">';

			$html .= '<div class="acfes-session-cell-content">';
			// Determine the session title
			if ( 'permalink' == $attr['session_link'] && ( 'custom' !== $session_type || 1 == $break_link ) ) {
				$html .= sprintf( '<h3><a class="acfes-session-title" href="%s">%s</a></h3>', esc_url( get_permalink( $session->ID ) ), $session_title );
			} elseif ( 'anchor' == $attr['session_link'] && ( 'custom' !== $session_type || 1 == $break_link ) ) {
				$html .= sprintf( '<h3><a class="acfes-session-title" href="%s">%s</a></h3>', esc_url( '#' . get_post_field( 'post_name', $session->ID ) ), $session_title );
			} else {
				$html .= sprintf( '<h3><span class="acfes-session-title">%s</span></h3>', $session_title );
			}

			// Add time to the output string
			$html .= '<div class="acfes-session-time">' . gmdate( $time_format, $start_time ) . ' - ' . gmdate( $time_format, $end_time ) . '</div>';

			// Add tracks to the output string
			$html .= '<div class="acfes-session-track">' . implode( ', ', $tracks_names_array ) . '</div>';

			// Add speakers names to the output string.
			if ( $speakers ) {
				if ( 'anchor' == $attr['session_link'] ) {
					$html .= '<div class="acfes-session-speakers">' . acfes_get_post_object_anchor_list( $speakers ) . '</div>';
				} else {
					$html .= '<div class="acfes-session-speakers">' . acfes_get_post_object_url_list( $speakers ) . '</div>';
				}
			}
			if ( function_exists( 'get_favorites_button' ) ) {
				$html .= get_favorites_button( $session->ID );
			}

			// Session Content Footer Filter
			$acfes_session_content_footer = apply_filters( 'acfes_session_content_footer', $session->ID );
			$html                        .= ( $acfes_session_content_footer != $session->ID ) ? $acfes_session_content_footer : '';

			$html .= '</div>';

			$html .= '</div>';
		}

		$html .= '</div>';

		return $html;

	} else {
		return '<p>No sessions can be found on ' . $attr['date'] . '</p>';
	}
}
