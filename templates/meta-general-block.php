<?php
$selected          = get_field( 'acfes_select_meta' ) ? get_field( 'acfes_select_meta' ) : array( 'social', 'web' );
$social_fieldname  = 'acfes_social_link_repeater';
$social            = get_field( $social_fieldname, get_the_ID() );
$web_fieldname     = 'acfes_web_link_repeater';
$web               = get_field( $web_fieldname, get_the_ID() );
$address_fieldname = 'acfes_address';
$address           = get_field( $address_fieldname, get_the_ID() );
$phone_fieldname   = 'acfes_phone_number';
$phone             = get_field( $phone_fieldname, get_the_ID() );
$email_fieldname   = 'acfes_email';
$email             = get_field( $email_fieldname, get_the_ID() );

if ( $selected && ( $social || $web || $files ) ) { ?>
	<div class="entry-meta block-meta">
		<h3><?php esc_html_e( 'Contact Info', 'acfes' ); ?></h3>
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

	// Email
	if ( $email && in_array( 'email', $selected, true ) ) {
		echo '<div class="email"><strong>Email: </strong>';
		echo '<a href="mailto:' . esc_html( $email ) . '">' . esc_html( $email ) . '</a>';
		echo '</div>';
	}

	// Address
	if ( $address && in_array( 'address', $selected, true ) ) {
		echo '<div class="address"><strong>Address: </strong>';
		echo wp_kses_post( wpautop( $address ) );
		echo '</div>';
	}

	// Phone
	if ( $phone && in_array( 'phone', $selected, true ) ) {
		echo '<div class="phone"><strong>Phone: </strong>';
		echo '<a href="tel:' . esc_html( $phone ) . '">' . esc_html( $phone ) . '</a>';
		echo '</div>';
	}
	?>
	</div>
	<?php
}
