<div class="entry-meta block-meta">
	<?php

	$selected         = get_field( 'acfes_select_meta' ) ? get_field( 'acfes_select_meta' ) : array( 'time', 'tracks', 'speakers' );
	$time_format      = get_option( 'time_format', 'g:i a' );
	$session_time     = strtotime( get_field( 'acfes_session_time', get_the_ID() ) );
	$session_end_time = strtotime( get_field( 'acfes_session_end_time', get_the_ID() ) );
	$session_date     = ( $session_time ) ? wp_date_localized( 'F j, Y', $session_time ) : '';
	$session_type     = get_field( 'acfes_session_type', get_the_ID() );

	// Check if end time is available. This is for pre version 1.0.1 as the end time wasn't available.
	if ( in_array( 'time', $selected, true ) ) {
		if ( $session_date && ! $session_end_time ) {
			echo '<time> ' . esc_html( $session_date ) . ' at ' . esc_html( gmdate( $time_format, $session_time ) ) . ' (' . esc_html( wp_timezone_string() ) . ')</time>';
		} elseif ( $session_date && $session_end_time ) {
			echo '<time> ' . esc_html( $session_date ) . ' from ' . esc_html( gmdate( $time_format, $session_time ) ) . ' to ' . esc_html( gmdate( $time_format, $session_end_time ) ) . ' (' . esc_html( wp_timezone_string() ) . ')</time>';
		}
	}

	// Tracks
	$tracks = get_the_term_list( $post->ID, 'acfes_track', '', ', ', '' );
	if ( $tracks && in_array( 'tracks', $selected, true ) ) {
		echo '<div class="session-tracks"><strong>Track: </strong>' . esc_html( wp_strip_all_tags( $tracks ) ) . '</div>';
	}

	// Locations
	$locations = get_the_term_list( $post->ID, 'acfes_location', '', ', ', '' );
	if ( $locations && in_array( 'locations', $selected, true ) ) {
		echo '<div class="session-location"><strong>Location: </strong>' . esc_html( wp_strip_all_tags( $locations ) ) . '</div>';
	}
	?>
</div><!-- .meta-info -->
