<?php // General Meta Block Wrapper
$class_name = 'acfes_module_meta acfes_session_meta widget';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
?>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<h3><?php esc_html_e( 'Session Info', 'acfes' ); ?></h3>
	<?php acfes_get_block_part( 'meta', 'session-block' ); ?>
</div>
