<?php // Post List Wrapper
$class_name = 'acfes_module_listgrid_posts';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
?>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<?php acfes_get_block_part( 'event', 'list-block' ); ?>
</div>
