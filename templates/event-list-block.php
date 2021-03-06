<?php // Event List Block

$content_type      = get_field( 'acfes_type_of_content' ) ? get_field( 'acfes_type_of_content' ) : 'session';
$list_query_number = get_field( 'acfes_archive_taxonomy_number' ) ? get_field( 'acfes_archive_taxonomy_number' ) : 3;
$list_query        = ''; // leave blank to define
$list_object       = ''; // leave blank to define
$notin             = ''; // defaults to sticky posts
$acfes_orderbyvar  = get_field( 'acfes_archive_order' ) ? get_field( 'acfes_archive_order' ) : 'title';
$acfes_ordervar    = 'ASC'; // low to high
$acfes_post_type   = 'acfes_' . $content_type;
$schedule_date     = get_field( 'acfes_session_date' );
$acfes_term_field  = $acfes_post_type . '_term';
$taxterm           = get_field( $acfes_term_field );
?>

<div class="content--inner">
	<div class="acfes-module--list <?php echo esc_attr( $content_type ); ?>-block">
		<?php
		// All From Post
		if ( 'all' === get_field( 'acfes_archive_select' ) ) :

			if ( 'session' === $content_type ) :
				$list_query = acfes_page_component_meta_tax_title_query( $acfes_post_type, $list_query_number, $taxterm, $schedule_date, $acfes_orderbyvar, $acfes_ordervar );
			else :
				$list_query = acfes_page_component_post_query( $acfes_post_type, $list_query_number, $acfes_orderbyvar, $acfes_ordervar, $notin );
			endif;


			// Specific Term
		elseif ( 'taxonomy' === get_field( 'acfes_archive_select' ) ) :

			if ( 'session' === $content_type ) :
				$list_query = acfes_page_component_meta_tax_title_query( $acfes_post_type, $list_query_number, $taxterm, $schedule_date, $acfes_orderbyvar, $acfes_ordervar );
			else :
				$list_query = acfes_taxonomy_query( $acfes_term_field, 1, $acfes_orderbyvar, $acfes_ordervar );
			endif;

			// Manual
		elseif ( 'manually' === get_field( 'acfes_archive_select' ) ) :

			$field_name  = 'acfes_archive_manual_' . $content_type . 's';
			$list_object = get_field( $field_name );

		endif;

		// List Query
		if ( $list_query ) :
			if ( $list_query->have_posts() ) :
				global $post;
				$org_post = $post; // save this in case we are inside a nested query/post object
				while ( $list_query->have_posts() ) :
					$list_query->the_post();
					acfes_get_block_part( 'content-list', $content_type );
				endwhile;
				$post = $org_post; // reset to original query
			else :
				echo __('No content matches your selected criteria.', 'acfes');
			endif;
			// List Object
		elseif ( $list_object ) :
			global $post;
			$org_post = $post; // save this in case we are inside a nested query/post object
			foreach ( $list_object as $post ) : // variable must be called $post (IMPORTANT)
					setup_postdata( $post );
					acfes_get_block_part( 'content-list', $content_type );
				endforeach;
			$post = $org_post; // reset to original query
		endif;
		?>
	</div>
</div>
