<?php // Event Single Block

$content_type    = get_field( 'acfes_type_of_content' );
$acfes_post_type = 'acfes_' . $content_type;
$single_field    = 'acfes_single_' . $content_type;
$post_object     = get_field( $single_field );

?>

<div class="content--inner">
	<div class="acfes-module--single <?php echo esc_attr( $content_type ); ?>-block">
		<?php
		// Post Object
		if ( $post_object ) :
			global $post;
			$org_post = $post; // save this in case we are inside a nested query/post object
			$post     = $post_object;
				setup_postdata( $post );
				acfes_get_block_part( 'content-single', $content_type );
			$post = $org_post; // reset to original query
		endif;
		?>
	</div>
</div>
