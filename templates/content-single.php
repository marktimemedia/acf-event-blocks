<?php // Generic Single List content

$featured     = get_field( 'acfcs_show_featured_images' );
$summary      = get_field( 'acfes_show_text_summary' );
$content_size = ( has_post_thumbnail() && $featured ) ? '' : '-full';
?>

<article class="acfes-content--single" id="<?php echo esc_html( acfes_anchor( get_the_title() ) ); ?>">

	<?php if ( has_post_thumbnail() && $featured ) : ?>
		<section class="acfes-list--image">
			<a aria-hidden="true" tabindex="-1" href="<?php the_permalink(); ?>"><figure class="post--thumbnail acfes-post-thumbnail" style="background-image:url(<?php the_post_thumbnail_url( 'medium_large' ); ?>)"></figure></a>
		</section>
	<?php endif; ?>

	<section class="acfes-list--post-content<?php echo esc_attr( $content_size ); ?>">
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php
		if ( $summary ) {
			the_excerpt();
		}
		?>
	</section>

</article>
