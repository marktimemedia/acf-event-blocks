<?php
/*
Template Name: Single Scroll Page
*/

acfes_load_wrap_header();
$jump = get_field( 'acfes_enable_jump_button' ) ? true : false; ?>

<section class="acfes-component acfes-component--home single-scroll-main">
	<section class="content--page">

		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>

	</section>
</section>

<?php
// Single Scroll Select (ACF Relationship Field)

$scroll_posts = get_field( 'acfes_select_pages' );

if ( $scroll_posts ) :

	$j = 1;

	foreach ( $scroll_posts as $post ) : // variable must be called $post (IMPORTANT)

		setup_postdata( $post );
		?>

		<section id="<?php echo esc_html( $post->post_name ); ?>" class= "acfes-component acfes-section-<?php echo esc_attr( $j++ ); ?>">
			<section class="content--<?php echo esc_html( $post->post_name ); ?>">
				<div class="content--page">

					<?php
					if ( $jump ) {
						acfes_get_block_part( 'acfes-block', 'jump-button' );
					}
					?>

					<?php the_content(); ?>

				</div>
			</section>
		</section>

		<?php
	endforeach;

	wp_reset_postdata();

endif;
?>

<?php acfes_load_wrap_footer(); ?>
