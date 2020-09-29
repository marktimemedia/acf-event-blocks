<?php

// Registers custom taxonomies to post types.
function acfes_register_taxonomies() {

	// Add new Location taxonomy, make it hierarchical (like categories)
		$location_labels = array(
			'name'                       => _x( 'Locations', 'taxonomy general name' ),
			'singular_name'              => _x( 'Location', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Locations' ),
			'all_items'                  => __( 'All Locations' ),
			'parent_item'                => __( 'Parent Location' ),
			'parent_item_colon'          => __( 'Parent Location:' ),
			'edit_item'                  => __( 'Edit Location' ),
			'update_item'                => __( 'Update Location' ),
			'add_new_item'               => __( 'Add New Location' ),
			'new_item_name'              => __( 'New Location Name' ),
			'menu_name'                  => __( 'Locations' ),
			'separate_items_with_commas' => __( 'Separate Locations with commas' ),
			'add_or_remove_items'        => __( 'Add or remove Locations' ),
			'choose_from_most_used'      => __( 'Choose from the most used Locations' ),
			'not_found'                  => __( 'No Locations found.' ),
		);

		$location_args = array(
			'hierarchical'      => true,
			'labels'            => $location_labels,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var'         => true,
			'show_in_rest'      => true,
			'rest_base'         => 'session_location',
			'rewrite'           => array( 'slug' => 'location' ),
		);

		// Register Location taxonomy to whichever post types are in the array
		register_taxonomy( 'acfes_location', array( 'acfes_session' ), $location_args );

		// Add new Track taxonomy, make it hierarchical (like categories)
		$track_labels = array(
			'name'                       => _x( 'Track', 'taxonomy general name' ),
			'singular_name'              => _x( 'Track', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Tracks' ),
			'all_items'                  => __( 'All Tracks' ),
			'parent_item'                => __( 'Parent Track' ),
			'parent_item_colon'          => __( 'Parent Track:' ),
			'edit_item'                  => __( 'Edit Track' ),
			'update_item'                => __( 'Update Track' ),
			'add_new_item'               => __( 'Add New Track' ),
			'new_item_name'              => __( 'New Track Name' ),
			'menu_name'                  => __( 'Tracks' ),
			'separate_items_with_commas' => __( 'Separate Tracks with commas' ),
			'add_or_remove_items'        => __( 'Add or remove Tracks' ),
			'choose_from_most_used'      => __( 'Choose from the most used Tracks' ),
			'not_found'                  => __( 'No Tracks found.' ),
		);

		$track_args = array(
			'hierarchical'      => true,
			'labels'            => $track_labels,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var'         => true,
			'show_in_rest'      => true,
			'rest_base'         => 'session_track',
			'rewrite'           => array( 'slug' => 'track' ),
		);

		// Register Track taxonomy to whichever post types are in the array
		register_taxonomy( 'acfes_track', array( 'acfes_session' ), $track_args );

		// Add new Session Category taxonomy, make it hierarchical (like categories)
		$track_labels = array(
			'name'                       => _x( 'Session Category', 'taxonomy general name' ),
			'singular_name'              => _x( 'Category', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Categories' ),
			'all_items'                  => __( 'All Categories' ),
			'parent_item'                => __( 'Parent Category' ),
			'parent_item_colon'          => __( 'Parent Category:' ),
			'edit_item'                  => __( 'Edit Category' ),
			'update_item'                => __( 'Update Category' ),
			'add_new_item'               => __( 'Add New Category' ),
			'new_item_name'              => __( 'New Category Name' ),
			'menu_name'                  => __( 'Categories' ),
			'separate_items_with_commas' => __( 'Separate Categories with commas' ),
			'add_or_remove_items'        => __( 'Add or remove Categories' ),
			'choose_from_most_used'      => __( 'Choose from the most used Categories' ),
			'not_found'                  => __( 'No Categories found.' ),
		);

		$track_args = array(
			'hierarchical'      => true,
			'labels'            => $track_labels,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var'         => true,
			'show_in_rest'      => true,
			'rest_base'         => 'session_category',
			'rewrite'           => array( 'slug' => 'session-category' ),
		);

		// Register Session Category taxonomy to whichever post types are in the array
		register_taxonomy( 'acfes_session_category', array( 'acfes_session' ), $track_args );

		// Add new Speaker Category taxonomy, make it hierarchical (like categories)
		$speaker_labels = array(
			'name'                       => _x( 'Speaker Category', 'taxonomy general name' ),
			'singular_name'              => _x( 'Category', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Categories' ),
			'all_items'                  => __( 'All Categories' ),
			'parent_item'                => __( 'Parent Category' ),
			'parent_item_colon'          => __( 'Parent Category:' ),
			'edit_item'                  => __( 'Edit Category' ),
			'update_item'                => __( 'Update Category' ),
			'add_new_item'               => __( 'Add New Category' ),
			'new_item_name'              => __( 'New Category Name' ),
			'menu_name'                  => __( 'Categories' ),
			'separate_items_with_commas' => __( 'Separate Categories with commas' ),
			'add_or_remove_items'        => __( 'Add or remove Categories' ),
			'choose_from_most_used'      => __( 'Choose from the most used Categories' ),
			'not_found'                  => __( 'No Categories found.' ),
		);

		$speaker_args = array(
			'hierarchical'      => true,
			'labels'            => $speaker_labels,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var'         => true,
			'show_in_rest'      => true,
			'rest_base'         => 'speaker_category',
			'rewrite'           => array( 'slug' => 'speaker-category' ),
		);

		// Register Speaker Category taxonomy to whichever post types are in the array
		register_taxonomy( 'acfes_speaker_category', array( 'acfes_speaker' ), $speaker_args );

		// Add new Level taxonomy, make it hierarchical (like categories)
		$level_labels = array(
			'name'                       => _x( 'Sponsor Level', 'taxonomy general name' ),
			'singular_name'              => _x( 'Level', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Levels' ),
			'all_items'                  => __( 'All Levels' ),
			'parent_item'                => __( 'Parent Level' ),
			'parent_item_colon'          => __( 'Parent Level:' ),
			'edit_item'                  => __( 'Edit Level' ),
			'update_item'                => __( 'Update Level' ),
			'add_new_item'               => __( 'Add New Level' ),
			'new_item_name'              => __( 'New Level Name' ),
			'menu_name'                  => __( 'Sponsor Levels' ),
			'separate_items_with_commas' => __( 'Separate Levels with commas' ),
			'add_or_remove_items'        => __( 'Add or remove Levels' ),
			'choose_from_most_used'      => __( 'Choose from the most used Levels' ),
			'not_found'                  => __( 'No Levels found.' ),
		);

		$level_args = array(
			'hierarchical'      => true,
			'labels'            => $level_labels,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var'         => true,
			'show_in_rest'      => true,
			'rest_base'         => '',
			'rewrite'           => array( 'slug' => 'sponsor-level' ),
		);

		// Register Level taxonomy to whichever post types are in the array
		register_taxonomy( 'acfes_level', array( 'acfes_sponsor' ), $level_args );

		// Add new Level taxonomy, make it hierarchical (like categories)
		$sponsor_category_labels = array(
			'name'                       => _x( 'Sponsor Category', 'taxonomy general name' ),
			'singular_name'              => _x( 'Category', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Categories' ),
			'all_items'                  => __( 'All Categories' ),
			'parent_item'                => __( 'Parent Category' ),
			'parent_item_colon'          => __( 'Parent Category:' ),
			'edit_item'                  => __( 'Edit Category' ),
			'update_item'                => __( 'Update Category' ),
			'add_new_item'               => __( 'Add New Category' ),
			'new_item_name'              => __( 'New Category Name' ),
			'menu_name'                  => __( 'Categories' ),
			'separate_items_with_commas' => __( 'Separate Categories with commas' ),
			'add_or_remove_items'        => __( 'Add or remove Categories' ),
			'choose_from_most_used'      => __( 'Choose from the most used Categories' ),
			'not_found'                  => __( 'No Categories found.' ),
		);

		$sponsor_category_args = array(
			'hierarchical'      => true,
			'labels'            => $sponsor_category_labels,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var'         => true,
			'show_in_rest'      => true,
			'rest_base'         => '',
			'rewrite'           => array( 'slug' => 'sponsor-category' ),
		);

		// Register Level taxonomy to whichever post types are in the array
		register_taxonomy( 'acfes_sponsor_category', array( 'acfes_sponsor' ), $sponsor_category_args );

		// Add new Exhibitor Category taxonomy, make it hierarchical (like categories)
		$exhibitor_category_labels = array(
			'name'                       => _x( 'Exhibitor Category', 'taxonomy general name' ),
			'singular_name'              => _x( 'Category', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Categories' ),
			'all_items'                  => __( 'All Categories' ),
			'parent_item'                => __( 'Parent Category' ),
			'parent_item_colon'          => __( 'Parent Category:' ),
			'edit_item'                  => __( 'Edit Category' ),
			'update_item'                => __( 'Update Category' ),
			'add_new_item'               => __( 'Add New Category' ),
			'new_item_name'              => __( 'New Category Name' ),
			'menu_name'                  => __( 'Categories' ),
			'separate_items_with_commas' => __( 'Separate Categories with commas' ),
			'add_or_remove_items'        => __( 'Add or remove Categories' ),
			'choose_from_most_used'      => __( 'Choose from the most used Categories' ),
			'not_found'                  => __( 'No Categories found.' ),
		);

		$exhibitor_category_args = array(
			'hierarchical'      => true,
			'labels'            => $exhibitor_category_labels,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var'         => true,
			'show_in_rest'      => true,
			'rest_base'         => '',
			'rewrite'           => array( 'slug' => 'exhibitor-category' ),
		);

		// Register Level taxonomy to whichever post types are in the array
		register_taxonomy( 'acfes_exhibitor_category', array( 'acfes_exhibitor' ), $exhibitor_category_args );

}

add_action( 'init', 'acfes_register_taxonomies' );
