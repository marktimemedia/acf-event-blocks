<?php
$selected         = get_field( 'acfes_select_meta' ) ? get_field( 'acfes_select_meta' ) : array( 'social', 'web' );
$social_fieldname = 'acfes_social_link_repeater';
$social           = get_field( $social_fieldname, get_the_ID() );
$web_fieldname    = 'acfes_web_link_repeater';
$web              = get_field( $web_fieldname, get_the_ID() );

if ( $selected && ( $social || $web ) ) { ?>
	<div class="entry-meta block-meta">
		<h3>Contact Info</h3>
	<?php
	// Social
	if ( $social && in_array( 'social', $selected, true ) ) {
		echo '<div class="social-links"><strong>Social Links: </strong>';
		echo wp_kses_post( get_acfes_social_icons( $social_fieldname, get_the_ID() ) );
		echo '</div>';
	}

	// Web
	if ( $web && in_array( 'web', $selected, true ) ) {
		echo '<div class="web-links"><strong>Web Links: </strong>';
		the_acfes_web_links( $web_fieldname, get_the_ID() );
		echo '</div>';
	}
	?>
	</div>
<?php } ?>
