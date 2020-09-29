<?php // Generic Single Grid content

$acfes_grid_row_class = acfes_output_row_number( 'acfes_number_per_row', get_option( 'acfes_grid_per_row' ) );
$featured             = get_field( 'acfcs_show_featured_images' ) ? get_field( 'acfcs_show_featured_images' ) : false;
$summary              = get_field( 'acfes_show_text_summary' ) ? get_field( 'acfes_show_text_summary' ) : false;
?>

<article class="acfes-grid--single <?php echo esc_attr( $acfes_grid_row_class ); ?>" id="<?php echo esc_html( acfes_anchor( get_the_title() ) ); ?>">
	<div class="acfes-grid--single-content">
		<?php if ( ( has_post_thumbnail() || get_theme_mod( 'mtm_default_image' ) ) && $featured ) : ?>
			<section class="acfes-grid--image">
				<?php the_acfes_post_thumbnail_cropped( 'medium_large', 'acfes-post-thumbnail', true ); ?>
			</section>
		<?php endif; ?>
		<section class="acfes-grid--post-content">
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php
			if ( $summary ) {
				the_excerpt();
			}
			?>
		</section>
	</div>
</article>
