<?php // Generic Single List content

$featured     = get_field( 'acfcs_show_featured_images' ) ? get_field( 'acfcs_show_featured_images' ) : true;
$summary      = get_field( 'acfes_show_text_summary' ) ? get_field( 'acfes_show_text_summary' ) : true;
$content_size = ( ( has_post_thumbnail() || get_theme_mod( 'mtm_default_image' ) ) && $featured ) ? '' : '-full';
?>

<article class="acfes-list--single" id="<?php echo esc_html( acfes_anchor( get_the_title() ) ); ?>">

	<?php if ( ( has_post_thumbnail() || get_theme_mod( 'mtm_default_image' ) ) && $featured ) : ?>
		<section class="acfes-list--image">
			<?php the_acfes_post_thumbnail_cropped( 'medium_large', 'acfes-post-thumbnail', true ); ?>
		</section>
	<?php endif; ?>

	<section class="acfes-list--post-content<?php echo esc_attr( $content_size ); ?>">
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( $summary ) : ?>
			<div class="acfes-list--excerpt">
			<?php the_excerpt(); ?>
		</div>
		<?php endif; ?>
	</section>

</article>
