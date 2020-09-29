<?php // Single Block Wrapper
$class_name = 'acfes_module_single';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
?>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<?php acfes_get_block_part( 'event', 'single-block' ); ?>
</div>
