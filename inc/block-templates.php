<?php
/**
* Custom Plugin Templates for Single and Archives
*/
add_filter( 'single_template', 'acfes_set_single_session_template' );
function acfes_set_single_session_template( $single_template ) {
	global $post;

	if ( 'acfes_session' === $post->post_type ) {
			$single_template = ACFES_DIR . '/templates/template-session-post.php';
	}
	return $single_template;
}

add_filter( 'archive_template', 'acfes_set_archive_template' );
function acfes_set_archive_template( $archive_template ) {
	global $post;

	if ( is_post_type_archive( 'acfes_session' ) || is_tax( 'acfes_location' ) || is_tax( 'acfes_track' ) || is_tax( 'acfes_session_category' ) ) {
		$archive_template = ACFES_DIR . '/templates/template-session-archive.php';
	} elseif ( is_post_type_archive( 'acfes_speaker' ) || is_tax( 'acfes_speaker_category' ) ) {
		$archive_template = ACFES_DIR . '/templates/template-speaker-archive.php';
	} elseif ( is_post_type_archive( 'acfes_sponsor' ) || is_tax( 'acfes_level' ) ) {
		$archive_template = ACFES_DIR . '/templates/template-sponsor-archive.php';
	} elseif ( is_post_type_archive( 'acfes_exhibitor' ) || is_tax( 'acfes_exhibitor_category' ) ) {
		$archive_template = ACFES_DIR . '/templates/template-exhibitor-archive.php';
	}
	return $archive_template;
}

/**
* Block Templates
*/
// Add Session templates
function acfes_add_session_templates() {
	// Call to action
	$mtm_cta = array('acf/mtm-block-call-to-action', array(), array (
			array('core/heading', array(
				'level'     => 2,
				'textColor' => 'neutral-lightest',
				'content'   => 'Register now to access this session and more!',
			)),
			array('core/paragraph', array(
				'fontSize'  => 'medium',
				'textColor' => 'neutral-lightest',
				'content'   => 'Already have a ticket? Sign in to your account to view all available sessions.'
			)),
			array( 'core/buttons', array(
				'className' => 'mtm-cta-buttons'
			), array(
				array( 'core/button', array(
					'text'            => 'Register now',
					'backgroundColor' => 'neutral-lightest',
					'textColor'       => 'neutral-lightest',
					'className'       => 'is-style-outline',
					'link'            => '/register',
				)),
				array( 'core/button', array(
					'text'            => 'Sign in to your account',
					'backgroundColor' => 'neutral-lightest',
					'textColor'       => 'neutral-lightest',
					'className'       => 'is-style-outline',
					'link'            => '/my-account',
				)),
			))
		));

	$cta = array('core/group',array(), array(
		array('core/heading', array(
			'level'   => 2,
			'content' => 'Register now to access this session and more!',
		)),
		array('core/paragraph', array(
			'fontSize' => 'medium',
			'content'  => 'Already have a ticket? Sign in to your account to view all available sessions.',
		)),
		array( 'core/buttons', array(), array(
			array( 'core/button', array(
				'text' => 'Register now',
				'link' => '/register',
			)),
			array( 'core/button', array(
				'text' => 'Sign in to your account',
				'link' => '/my-account',
			)),
		))
	));

	$call_to_action = acfes_check_block_registry( 'acf/mtm-block-call-to-action' ) ? $mtm_cta : $cta;

	// members embed
	$member_embed_chat = array('core/group',array(
				'align' => 'wide',
				'className' => 'member-group-content'
	), array(
		array('woocommerce-memberships/member-content', array(
		'membershipPlans' => array(),
		), array(
			array('core/columns', array(
					'className' => 'embed-chat-columns',
					), array(
					array('core/column', array(
						'width'             => 77,
						'verticalAlignment' => 'top',
						'className'         => 'video-column',
						), array(
							array('acf/acfes-block-embed'),
					)),
					array('core/column', array(
						'width'             => 23,
						'verticalAlignment' => 'top',
						'className'         => 'chat-column',
						), array(
							array('acf/acfes-block-embed', array(
								'field_5eea3aedaf72e' => 'wp-embed-aspect-1-2',
							)),
					)),
			)),
		)),
		array('woocommerce-memberships/non-member-content', array(), array(
			// $call_to_action,
			array( 'core/paragraph' ),
		))
	));
	// non members embed
	$non_member_embed_chat = array('core/columns', array(
			'className' => 'embed-chat-columns',
			), array(
					array( 'core/column', array(
						'width' => 75,
						'verticalAlignment' => 'top',
						"className" => "video-column",
						), array(
							array( 'acf/acfes-block-embed' ),
					) ),
					array( 'core/column', array(
						'width' => 25,
						'verticalAlignment' => 'top',
						"className" => "chat-column",
						), array(
							array('acf/acfes-block-embed', array(
								'field_5eea3aedaf72e' => 'wp-embed-aspect-1-2'
							)),
					)),
	));

	$headline_block        = acfes_check_block_registry( 'acf/spring-headline' ) ? array( 'acf/spring-headline' ) : array( 'core/heading', array( 'level' => 1 ) );
	$embed_block           = function_exists( 'wc_memberships' ) ? $member_embed_chat : $non_member_embed_chat;
	$files_block           = function_exists( 'wc_memberships' ) ? array( 'woocommerce-memberships/member-content', array(), array( array( 'acf/acfes-block-file-list' ) ) ) : array( 'acf/acfes-block-file-list' );
	$post_object           = get_post_type_object( 'acfes_session' );

	$post_object->template = array(
		array( 'core/cover', array(
			'align' => 'full',
			'overlayColor' => 'neutral-darkest',
			'minHeight' => 200
		),
			array( $headline_block )
		),
		$embed_block,
		array('core/columns', array(
				), array(
						array( 'core/column', array(
							'width'             => 25,
							'verticalAlignment' => 'top',
							'className'         => 'sidebar-main content--sidebar',
							), array(
								array( 'acf/acfes-block-session-meta' ),
								$files_block,
								array( 'acf/acfes-block-speaker-list' ),
								array( 'acf/acfes-block-sponsor-list' ),
						) ),
						array( 'core/column', array(
							'width'             => 75,
							'verticalAlignment' => 'top',
							'className'         => 'content-main',
							), array(
								array( 'core/paragraph', array(
									'placeholder' => 'Add your session description text or other custom blocks...',
								) ),
						) ),
		)),
	);
}
add_action( 'init', 'acfes_add_session_templates' );

// Add Speaker templates
function acfes_add_speaker_templates() {
	$headline_block     = acfes_check_block_registry( 'acf/spring-headline' ) ? array( 'acf/spring-headline' ) : array( 'core/heading', array( 'level' => 1 ) );
	$featured_img_block = acfes_check_block_registry( 'acf/spring-featured-image' ) ? array( 'acf/spring-featured-image' ) : array();
	$post_object        = get_post_type_object( 'acfes_speaker' );

	$post_object->template = array(
		array( 'core/cover', array(
			'align'        => 'full',
			'overlayColor' => 'neutral-darkest',
		), array(
			$featured_img_block,
		) ),
		array('core/columns', array(
				), array(
						array( 'core/column', array(
							'width'             => 25,
							'verticalAlignment' => 'top',
							'className'         => 'sidebar-main content--sidebar',
							), array(
								array( 'acf/acfes-block-speaker-meta' ),
								array( 'acf/acfes-block-session-list' ),
								array( 'acf/acfes-block-sponsor-list' ),
						) ),
						array( 'core/column', array(
							'width'             => 75,
							'verticalAlignment' => 'top',
							'className'         => 'content-main',
							), array(
								$headline_block,
								array( 'core/paragraph', array(
										'placeholder' => 'Add your speaker description text or other custom blocks...',
								) ),
						) ),
		)),
	);
}
add_action( 'init', 'acfes_add_speaker_templates' );

// Add Sponsor templates
function acfes_add_sponsor_templates() {
	$headline_block     = acfes_check_block_registry( 'acf/spring-headline' ) ? array( 'acf/spring-headline' ) : array( 'core/heading', array( 'level' => 1 ) );
	$featured_img_block = acfes_check_block_registry( 'acf/spring-featured-image' ) ? array( 'acf/spring-featured-image' ) : array();
	$files_block        = function_exists( 'wc_memberships' ) ? array( 'woocommerce-memberships/member-content', array(), array( array( 'acf/acfes-block-file-list' ) ) ) : array( 'acf/acfes-block-file-list' );
	$post_object        = get_post_type_object( 'acfes_sponsor' );

	$post_object->template = array(
		array( 'core/cover', array(
			'align'        => 'full',
			'overlayColor' => 'neutral-darkest',
		), array(
			$featured_img_block,
		) ),
		array('core/columns', array(
				), array(
						array( 'core/column', array(
							'width'             => 25,
							'verticalAlignment' => 'top',
							'className'         => 'sidebar-main content--sidebar',
							), array(
								array( 'acf/acfes-block-meta' ),
								$files_block,
								array( 'acf/acfes-block-speaker-list' ),
								array( 'acf/acfes-block-session-list' ),
						) ),
						array( 'core/column', array(
							'width'             => 75,
							'verticalAlignment' => 'top',
							'className'         => 'content-main',
							), array(
								$headline_block,
								array( 'core/paragraph', array(
										'placeholder' => 'Add your sponsor description text or other custom blocks...',
								) ),
						) ),
		)),
	);
}
add_action( 'init', 'acfes_add_sponsor_templates' );

// Add Exhibitor templates
function acfes_add_exhibitor_templates() {
	$headline_block     = acfes_check_block_registry( 'acf/spring-headline' ) ? array( 'acf/spring-headline' ) : array( 'core/heading', array( 'level' => 1 ) );
	$featured_img_block = acfes_check_block_registry( 'acf/spring-featured-image' ) ? array( 'acf/spring-featured-image' ) : array();
	$files_block        = function_exists( 'wc_memberships' ) ? array( 'woocommerce-memberships/member-content', array(), array( array( 'acf/acfes-block-file-list' ) ) ) : array( 'acf/acfes-block-file-list' );
	$post_object        = get_post_type_object( 'acfes_exhibitor' );

	$post_object->template = array(
		array( 'core/cover', array(
			'align'        => 'full',
			'overlayColor' => 'neutral-darkest',
		), array(
			$featured_img_block,
		) ),
		array('core/columns', array(
				), array(
						array( 'core/column', array(
							'width'             => 25,
							'verticalAlignment' => 'top',
							'className'         => 'sidebar-main content--sidebar',
							), array(
								array( 'acf/acfes-block-meta' ),
								$files_block,
								array( 'acf/acfes-block-speaker-list' ),
								array( 'acf/acfes-block-session-list' ),
						) ),
						array( 'core/column', array(
							'width'             => 75,
							'verticalAlignment' => 'top',
							'className'         => 'content-main',
							), array(
								$headline_block,
								array( 'core/paragraph', array(
										'placeholder' => 'Add your sponsor description text or other custom blocks...',
								) ),
						) ),
		)),
	);
}
add_action( 'init', 'acfes_add_exhibitor_templates' );
