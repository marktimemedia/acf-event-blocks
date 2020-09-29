<?php

register_deactivation_hook( PLUGIN_FILE_URL, 'flush_rewrite_rules' );
register_activation_hook( PLUGIN_FILE_URL, 'acfes_flush_rewrites' );
/**
 * Flush rewrite rules on activation
 */
function acfes_flush_rewrites() {
	// call your CPT registration function here (it should also be hooked into 'init')
	acfes_register_post_types();
	flush_rewrite_rules();
}

// Registers the custom post types, runs during init.
add_action( 'init', 'acfes_register_post_types' );
function acfes_register_post_types() {

	// Session Post Type
		$sessionlabels = array(
			'name'               => _x( 'Sessions', 'post type general name' ),
			'singular_name'      => _x( 'Session', 'post type singular name' ),
			'menu_name'          => _x( 'Sessions', 'admin menu' ),
			'name_admin_bar'     => _x( 'Session', 'add new on admin bar' ),
			'add_new'            => _x( 'Add New', 'Session' ),
			'add_new_item'       => __( 'Add New Session' ),
			'new_item'           => __( 'New Session' ),
			'edit_item'          => __( 'Edit Session' ),
			'view_item'          => __( 'View Session' ),
			'all_items'          => __( 'All Sessions' ),
			'search_items'       => __( 'Search Sessions' ),
			'not_found'          => __( 'No Sessions found.' ),
			'not_found_in_trash' => __( 'No Sessions found in Trash.' ),
			'parent_item'        => __( 'Parent Session' ),
			'parent_item_colon'  => __( 'Parent Session:' ),
		);

		$sessionargs = array(
			'labels'              => $sessionlabels,
			'public'              => true, // bool (default is FALSE)
			'publicly_queryable'  => true, // bool (defaults to 'public')
			'exclude_from_search' => false, // bool (defaults to 'public')
			'show_ui'             => true, // bool (defaults to 'public')
			'show_in_menu'        => true, // bool (defaults to 'show_ui')
			'show_in_nav_menus'   => true, // bool (defaults to 'public')
			'show_in_admin_bar'   => true, // bool (defaults to 'show_in_menu')
			'show_in_rest'        => true, // bool (for gutenberg support)
			'rest_base'           => 'sessions',
			'query_var'           => true, // bool|string (defaults to TRUE - post type name)
			'rewrite'             => array( 'slug' => 'session', 'with_front' => false ), // true/false whether to append slug to url i.e. /blog/blog-post
			'capability_type'     => 'acfes_session',
			'capabilities'        => array(
				'publish_posts'      => 'publish_acfes_sessions',
				'edit_posts'         => 'edit_acfes_sessions',
				'edit_others_posts'  => 'edit_others_acfes_sessions',
				'read_private_posts' => 'read_private_acfes_sessions',
				'edit_post'          => 'edit_acfes_session',
				'delete_post'        => 'delete_acfes_session',
				'read_post'          => 'read_acfes_session',
			),
			'has_archive'         => false, // bool|string (defaults to FALSE)
			'hierarchical'        => false, // bool (defaults to FALSE)
			'menu_position'       => 5, // int SEE COMMENTS AT BOTTOM
			'menu_icon'           => 'dashicons-schedule', //https://developer.wordpress.org/resource/dashicons/
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'publicize', 'wpcom-markdown', 'custom-fields' ),
		);

		// Register Session post type
		register_post_type( 'acfes_session', $sessionargs );

		// Speaker Post Type
		$speakerlabels = array(
			'name'               => _x( 'Speakers', 'post type general name' ),
			'singular_name'      => _x( 'Speaker', 'post type singular name' ),
			'menu_name'          => _x( 'Speakers', 'admin menu' ),
			'name_admin_bar'     => _x( 'Speaker', 'add new on admin bar' ),
			'add_new'            => _x( 'Add New', 'Speaker' ),
			'add_new_item'       => __( 'Add New Speaker' ),
			'new_item'           => __( 'New Speaker' ),
			'edit_item'          => __( 'Edit Speaker' ),
			'view_item'          => __( 'View Speaker' ),
			'all_items'          => __( 'All Speakers' ),
			'search_items'       => __( 'Search Speakers' ),
			'not_found'          => __( 'No Speakers found.' ),
			'not_found_in_trash' => __( 'No Speakers found in Trash.' ),
			'parent_item'        => __( 'Parent Speaker' ),
			'parent_item_colon'  => __( 'Parent Speaker:' ),
		);

		$speakerargs = array(
			'labels'              => $speakerlabels,
			'public'              => true, // bool (default is FALSE)
			'publicly_queryable'  => true, // bool (defaults to 'public')
			'exclude_from_search' => false, // bool (defaults to 'public')
			'show_ui'             => true, // bool (defaults to 'public')
			'show_in_menu'        => true, // bool (defaults to 'show_ui')
			'show_in_nav_menus'   => true, // bool (defaults to 'public')
			'show_in_admin_bar'   => true, // bool (defaults to 'show_in_menu')
			'show_in_rest'        => true, // bool (for gutenberg support)
			'query_var'           => true, // bool|string (defaults to TRUE - post type name)
			'rewrite'             => array( 'slug' => 'speaker', 'with_front' => false ), // true/false whether to append slug to url i.e. /blog/blog-post
			'capability_type'     => 'acfes_speaker',
			'capabilities'        => array(
				'publish_posts'      => 'publish_acfes_speakers',
				'edit_posts'         => 'edit_acfes_speakers',
				'edit_others_posts'  => 'edit_others_acfes_speakers',
				'read_private_posts' => 'read_private_acfes_speakers',
				'edit_post'          => 'edit_acfes_speaker',
				'delete_post'        => 'delete_acfes_speaker',
				'read_post'          => 'read_acfes_speaker',
			),
			'has_archive'         => true, // bool|string (defaults to FALSE)
			'hierarchical'        => false, // bool (defaults to FALSE)
			'menu_position'       => 6, // int SEE COMMENTS AT BOTTOM
			'menu_icon'           => 'dashicons-id', //https://developer.wordpress.org/resource/dashicons/
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'publicize', 'wpcom-markdown', 'custom-fields' ),
		);

		// Register Speaker post type
		register_post_type( 'acfes_speaker', $speakerargs );

	// Sponsor Post Type
		$sponsorlabels = array(
			'name'               => _x( 'Sponsors', 'post type general name' ),
			'singular_name'      => _x( 'Sponsor', 'post type singular name' ),
			'menu_name'          => _x( 'Sponsors', 'admin menu' ),
			'name_admin_bar'     => _x( 'Sponsor', 'add new on admin bar' ),
			'add_new'            => _x( 'Add New', 'Sponsor' ),
			'add_new_item'       => __( 'Add New Sponsor' ),
			'new_item'           => __( 'New Sponsor' ),
			'edit_item'          => __( 'Edit Sponsor' ),
			'view_item'          => __( 'View Sponsor' ),
			'all_items'          => __( 'All Sponsors' ),
			'search_items'       => __( 'Search Sponsors' ),
			'not_found'          => __( 'No Sponsors found.' ),
			'not_found_in_trash' => __( 'No Sponsors found in Trash.' ),
			'parent_item'        => __( 'Parent Sponsor' ),
			'parent_item_colon'  => __( 'Parent Sponsor:' ),
		);

		$sponsorargs = array(
			'labels'              => $sponsorlabels,
			'public'              => true, // bool (default is FALSE)
			'publicly_queryable'  => true, // bool (defaults to 'public')
			'exclude_from_search' => false, // bool (defaults to 'public')
			'show_ui'             => true, // bool (defaults to 'public')
			'show_in_menu'        => true, // bool (defaults to 'show_ui')
			'show_in_nav_menus'   => true, // bool (defaults to 'public')
			'show_in_admin_bar'   => true, // bool (defaults to 'show_in_menu')
			'show_in_rest'        => true, // bool (for gutenberg support)
			'query_var'           => true, // bool|string (defaults to TRUE - post type name)
			'rewrite'             => array( 'slug' => 'sponsor', 'with_front' => false ), // true/false whether to append slug to url i.e. /blog/blog-post
			'capability_type'     => 'acfes_sponsor',
			'capabilities'        => array(
				'publish_posts'      => 'publish_acfes_sponsors',
				'edit_posts'         => 'edit_acfes_sponsors',
				'edit_others_posts'  => 'edit_others_acfes_sponsors',
				'read_private_posts' => 'read_private_acfes_sponsors',
				'edit_post'          => 'edit_acfes_sponsor',
				'delete_post'        => 'delete_acfes_sponsor',
				'read_post'          => 'read_acfes_sponsor',
			),
			'has_archive'         => true, // bool|string (defaults to FALSE)
			'hierarchical'        => false, // bool (defaults to FALSE)
			'menu_position'       => 7, // int SEE COMMENTS AT BOTTOM
			'menu_icon'           => 'dashicons-nametag', //https://developer.wordpress.org/resource/dashicons/
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'publicize', 'wpcom-markdown', 'custom-fields' ),
		);

		// Register Sponsor post type
		register_post_type( 'acfes_sponsor', $sponsorargs );

	// Exhibitor Post Type
		$exhibitorlabels = array(
			'name'               => _x( 'Exhibitors', 'post type general name' ),
			'singular_name'      => _x( 'Exhibitor', 'post type singular name' ),
			'menu_name'          => _x( 'Exhibitors', 'admin menu' ),
			'name_admin_bar'     => _x( 'Exhibitor', 'add new on admin bar' ),
			'add_new'            => _x( 'Add New', 'Exhibitor' ),
			'add_new_item'       => __( 'Add New Exhibitor' ),
			'new_item'           => __( 'New Exhibitor' ),
			'edit_item'          => __( 'Edit Exhibitor' ),
			'view_item'          => __( 'View Exhibitor' ),
			'all_items'          => __( 'All Exhibitors' ),
			'search_items'       => __( 'Search Exhibitors' ),
			'not_found'          => __( 'No Exhibitors found.' ),
			'not_found_in_trash' => __( 'No Exhibitors found in Trash.' ),
			'parent_item'        => __( 'Parent Exhibitor' ),
			'parent_item_colon'  => __( 'Parent Exhibitor:' ),
		);

		$exhibitorargs = array(
			'labels'              => $exhibitorlabels,
			'public'              => true, // bool (default is FALSE)
			'publicly_queryable'  => true, // bool (defaults to 'public')
			'exclude_from_search' => false, // bool (defaults to 'public')
			'show_ui'             => true, // bool (defaults to 'public')
			'show_in_menu'        => true, // bool (defaults to 'show_ui')
			'show_in_nav_menus'   => true, // bool (defaults to 'public')
			'show_in_admin_bar'   => true, // bool (defaults to 'show_in_menu')
			'show_in_rest'        => true, // bool (for gutenberg support)
			'query_var'           => true, // bool|string (defaults to TRUE - post type name)
			'rewrite'             => array( 'slug' => 'exhibitor', 'with_front' => false ), // true/false whether to append slug to url i.e. /blog/blog-post
			'capability_type'     => 'acfes_exhibitor',
			'capabilities'        => array(
				'publish_posts'      => 'publish_acfes_exhibitors',
				'edit_posts'         => 'edit_acfes_exhibitors',
				'edit_others_posts'  => 'edit_others_acfes_exhibitors',
				'read_private_posts' => 'read_private_acfes_exhibitors',
				'edit_post'          => 'edit_acfes_exhibitor',
				'delete_post'        => 'delete_acfes_exhibitor',
				'read_post'          => 'read_acfes_exhibitor',
			),
			'has_archive'         => true, // bool|string (defaults to FALSE)
			'hierarchical'        => false, // bool (defaults to FALSE)
			'menu_position'       => 8, // int SEE COMMENTS AT BOTTOM
			'menu_icon'           => 'dashicons-awards', //https://developer.wordpress.org/resource/dashicons/
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'publicize', 'wpcom-markdown', 'custom-fields' ),
		);

		// Register Exhibitor post type
		register_post_type( 'acfes_exhibitor', $exhibitorargs );

}

// Change CPT title text
add_action( 'gettext', 'acfes_change_title_text' );
function acfes_change_title_text( $translation ) {
	global $post;
	if ( isset( $post ) ) {
		switch( $post->post_type ) {
			case 'acfes_session':
				if ( 'Add title' === $translation ) {
					return 'Enter Session Title Here';
				}
			case 'acfes_speaker':
				if ( 'Add title' === $translation ) {
					return 'Enter Speaker Name Here';
				}
			case 'acfes_speaker':
				if ( 'Add title' === $translation ) {
					return 'Enter Sponsor Name Here';
				}
				break;
		}
	}
	return $translation;
}

// Add CPTs to Dashboad At A Glance Metabox
add_action( 'dashboard_glance_items', 'acfes_cpt_at_glance' );
function acfes_cpt_at_glance() {
	$args     = array(
		'public'   => true,
		'_builtin' => false,
	);
	$output   = 'object';
	$operator = 'and';

	$acfes_post_types = get_post_types( $args, $output, $operator );
	foreach ( $acfes_post_types as $acfes_post_type ) {
		$num_posts = wp_count_posts( $acfes_post_type->name );
		$num       = number_format_i18n( $num_posts->publish );
		$text      = _n( $acfes_post_type->labels->singular_name, $acfes_post_type->labels->name, intval( $num_posts->publish ) );
		if ( current_user_can( 'edit_posts' ) ) {
			$output = '<a href="edit.php?post_type=' . $acfes_post_type->name . '">' . $num . ' ' . $text . '</a>';
			echo '<li class="post-count ' . esc_html( $acfes_post_type->name ) . '-count">' . $output . '</li>';
		} else {
			$output = '<span>' . $num . ' ' . $text . '</span>';
			echo '<li class="post-count ' . esc_html( $acfes_post_type->name ) . '-count">' . $output . '</li>';
		}
	}
}

/**
* Add custom capabilities to admin
*/
add_action(
	'init',
	function() {
		$role = get_role( 'administrator' );
		$cpt  = array( 'acfes_sponsor', 'acfes_speaker', 'acfes_session', 'acfes_exhibitor' );
		$cpts = array( 'acfes_sponsors', 'acfes_speakers', 'acfes_sessions', 'acfes_exhibitors' );

		foreach ( $cpt as $key => $value ) {
			$role->add_cap( 'edit_' . $value );
			$role->add_cap( 'delete_' . $value );
			$role->add_cap( 'read_' . $value );
		}
		foreach ( $cpts as $key => $value ) {
			$role->add_cap( 'publish_' . $value );
			$role->add_cap( 'edit_' . $value );
			$role->add_cap( 'edit_others_' . $value );
			$role->add_cap( 'read_private_' . $value );
		}
	}
);
