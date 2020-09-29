<?php
/**
 * Config
 */

/**
* Make compatible with non Roots/Sage based themes by calling header and footer
*/
if ( ! function_exists( 'acfes_load_wrap' ) ) {
	function acfes_load_wrap() {
		if ( class_exists( 'SageWrapping' ) || class_exists( 'Spring_Wrapping' ) ) {
			return false;
		}

		return true;
	}
	add_action( 'after_setup_theme', 'acfes_load_wrap' );
}

/**
* Load header on standard themes
*/
if ( ! function_exists( 'acfes_load_wrap_header' ) ) {
	function acfes_load_wrap_header() {

		if ( acfes_load_wrap() ) {
			get_header();
			echo '<main id="main" class="site-main" role="main">';
		}
	}
}
/**
* Load footer on standard themes
*/
if ( ! function_exists( 'acfes_load_wrap_footer' ) ) {
	function acfes_load_wrap_footer() {

		if ( acfes_load_wrap() ) {
			echo '</main>';
			get_footer();
		}
	}
}


/**
* Alphabetize CPT Archives
*/
function acfes_alphabetize_cpt_archives( $query ) {
	if ( ! is_admin() && ( is_post_type_archive( 'acfes_session' ) || is_post_type_archive( 'acfes_speaker' ) || is_post_type_archive( 'acfes_sponsor' || is_post_type_archive( 'acfes_exhibitor' ) ) ) ) {
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );
	}
}
add_action( 'pre_get_posts', 'acfes_alphabetize_cpt_archives' );


/**
 * Set our Social Icons URLs.
 * Only needed for our sample customizer preview refresh
 *
 * @return array Multidimensional array containing social media data
 */
if ( ! function_exists( 'acfes_generate_social_urls' ) ) {
	function acfes_generate_social_urls() {
		$social_icons = array(
			array(
				'url'   => 'behance.net',
				'icon'  => 'fab fa-behance',
				'title' => esc_html__( 'Follow me on Behance', 'mtm' ),
				'class' => 'behance',
			),
			array(
				'url'   => 'bitbucket.org',
				'icon'  => 'fab fa-bitbucket',
				'title' => esc_html__( 'Fork me on Bitbucket', 'mtm' ),
				'class' => 'bitbucket',
			),
			array(
				'url'   => 'codepen.io',
				'icon'  => 'fab fa-codepen',
				'title' => esc_html__( 'Follow me on CodePen', 'mtm' ),
				'class' => 'codepen',
			),
			array(
				'url'   => 'deviantart.com',
				'icon'  => 'fab fa-deviantart',
				'title' => esc_html__( 'Watch me on DeviantArt', 'mtm' ),
				'class' => 'deviantart',
			),
			array(
				'url'   => 'discord.gg',
				'icon'  => 'fab fa-discord',
				'title' => esc_html__( 'Join me on Discord', 'mtm' ),
				'class' => 'discord',
			),
			array(
				'url'   => 'dribbble.com',
				'icon'  => 'fab fa-dribbble',
				'title' => esc_html__( 'Follow me on Dribbble', 'mtm' ),
				'class' => 'dribbble',
			),
			array(
				'url'   => 'etsy.com',
				'icon'  => 'fab fa-etsy',
				'title' => esc_html__( 'favorite me on Etsy', 'mtm' ),
				'class' => 'etsy',
			),
			array(
				'url'   => 'facebook.com',
				'icon'  => 'fab fa-facebook-f',
				'title' => esc_html__( 'Like me on Facebook', 'mtm' ),
				'class' => 'facebook',
			),
			array(
				'url'   => 'flickr.com',
				'icon'  => 'fab fa-flickr',
				'title' => esc_html__( 'Connect with me on Flickr', 'mtm' ),
				'class' => 'flickr',
			),
			array(
				'url'   => 'foursquare.com',
				'icon'  => 'fab fa-foursquare',
				'title' => esc_html__( 'Follow me on Foursquare', 'mtm' ),
				'class' => 'foursquare',
			),
			array(
				'url'   => 'github.com',
				'icon'  => 'fab fa-github',
				'title' => esc_html__( 'Fork me on GitHub', 'mtm' ),
				'class' => 'github',
			),
			array(
				'url'   => 'instagram.com',
				'icon'  => 'fab fa-instagram',
				'title' => esc_html__( 'Follow me on Instagram', 'mtm' ),
				'class' => 'instagram',
			),
			array(
				'url'   => 'kickstarter.com',
				'icon'  => 'fab fa-kickstarter-k',
				'title' => esc_html__( 'Back me on Kickstarter', 'mtm' ),
				'class' => 'kickstarter',
			),
			array(
				'url'   => 'last.fm',
				'icon'  => 'fab fa-lastfm',
				'title' => esc_html__( 'Follow me on Last.fm', 'mtm' ),
				'class' => 'lastfm',
			),
			array(
				'url'   => 'linkedin.com',
				'icon'  => 'fab fa-linkedin-in',
				'title' => esc_html__( 'Connect with me on LinkedIn', 'mtm' ),
				'class' => 'linkedin',
			),
			array(
				'url'   => 'medium.com',
				'icon'  => 'fab fa-medium-m',
				'title' => esc_html__( 'Follow me on Medium', 'mtm' ),
				'class' => 'medium',
			),
			array(
				'url'   => 'open.spotify.com',
				'icon'  => 'fab fa-spotify',
				'title' => esc_html__( 'Follow me on Spotify', 'mtm' ),
				'class' => 'spotify',
			),
			array(
				'url'   => 'patreon.com',
				'icon'  => 'fab fa-patreon',
				'title' => esc_html__( 'Support me on Patreon', 'mtm' ),
				'class' => 'patreon',
			),
			array(
				'url'   => 'pinterest.com',
				'icon'  => 'fab fa-pinterest-p',
				'title' => esc_html__( 'Follow me on Pinterest', 'mtm' ),
				'class' => 'pinterest',
			),
			array(
				'url'   => 'plus.google.com',
				'icon'  => 'fab fa-google-plus-g',
				'title' => esc_html__( 'Connect with me on Google+', 'mtm' ),
				'class' => 'googleplus',
			),
			array(
				'url'   => 'reddit.com',
				'icon'  => 'fab fa-reddit-alien',
				'title' => esc_html__( 'Join me on Reddit', 'mtm' ),
				'class' => 'reddit',
			),
			array(
				'url'   => 'slack.com',
				'icon'  => 'fab fa-slack-hash',
				'title' => esc_html__( 'Join me on Slack', 'mtm' ),
				'class' => 'slack.',
			),
			array(
				'url'   => 'slideshare.net',
				'icon'  => 'fab fa-slideshare',
				'title' => esc_html__( 'Follow me on SlideShare', 'mtm' ),
				'class' => 'slideshare',
			),
			array(
				'url'   => 'snapchat.com',
				'icon'  => 'fab fa-snapchat-ghost',
				'title' => esc_html__( 'Add me on Snapchat', 'mtm' ),
				'class' => 'snapchat',
			),
			array(
				'url'   => 'soundcloud.com',
				'icon'  => 'fab fa-soundcloud',
				'title' => esc_html__( 'Follow me on SoundCloud', 'mtm' ),
				'class' => 'soundcloud',
			),
			array(
				'url'   => 'spotify.com',
				'icon'  => 'fab fa-spotify',
				'title' => esc_html__( 'Follow me on Spotify', 'mtm' ),
				'class' => 'spotify',
			),
			array(
				'url'   => 'stackoverflow.com',
				'icon'  => 'fab fa-stack-overflow',
				'title' => esc_html__( 'Join me on Stack Overflow', 'mtm' ),
				'class' => 'stackoverflow',
			),
			array(
				'url'   => 'tumblr.com',
				'icon'  => 'fab fa-tumblr',
				'title' => esc_html__( 'Follow me on Tumblr', 'mtm' ),
				'class' => 'tumblr',
			),
			array(
				'url'   => 'twitch.tv',
				'icon'  => 'fab fa-twitch',
				'title' => esc_html__( 'Follow me on Twitch', 'mtm' ),
				'class' => 'twitch',
			),
			array(
				'url'   => 'twitter.com',
				'icon'  => 'fab fa-twitter',
				'title' => esc_html__( 'Follow me on Twitter', 'mtm' ),
				'class' => 'twitter',
			),
			array(
				'url'   => 'vimeo.com',
				'icon'  => 'fab fa-vimeo-v',
				'title' => esc_html__( 'Follow me on Vimeo', 'mtm' ),
				'class' => 'vimeo',
			),
			array(
				'url'   => 'weibo.com',
				'icon'  => 'fab fa-weibo',
				'title' => esc_html__( 'Follow me on weibo', 'mtm' ),
				'class' => 'weibo',
			),
			array(
				'url'   => 'youtube.com',
				'icon'  => 'fab fa-youtube',
				'title' => esc_html__( 'Subscribe to me on YouTube', 'mtm' ),
				'class' => 'youtube',
			),
		);

		return apply_filters( 'acfes_social_icons', $social_icons );
	}
}
