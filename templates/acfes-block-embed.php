<?php // Speaker List
$class_name = 'acfes_module_embed';
$embed      = get_field( 'acfes_oembed' );
$iframe     = get_field( 'acfes_html' );
$ratio      = get_field( 'acfes_aspect_ratio' );

if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
if ( $ratio ) {
	$class_name .= ' wp-has-aspect-ratio ' . $ratio;
}


if ( $embed ) : ?>
<figure class="<?php echo esc_attr( $class_name ); ?>">
	<div class="wp-block-embed__wrapper">
		<?php the_field( 'acfes_oembed' ); ?>
	</div>
</figure>
<?php elseif ( $iframe ) : ?>
<figure class="<?php echo esc_attr( $class_name ); ?>">
	<div class="wp-block-embed__wrapper">
		<?php the_field( 'acfes_html' ); ?>
	</div>
</figure>
<?php else : ?>
	<span class="no-embeds"></span>
<?php endif; ?>
