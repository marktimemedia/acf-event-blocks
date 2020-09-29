<?php // Sponsor List
$class_name = 'acfes_module_meta acfes_sponsor_list widget';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
$session_sponsors = get_field( 'acfes_session_sponsors', get_the_ID() );

if ( $session_sponsors ) : ?>
<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="entry-meta block-meta">
		<h3><?php esc_html_e( 'Organizations', 'acfes' ); ?></h3>
			<div class="session-sponsors"><?php echo wp_kses_post( acfes_get_post_object_image_list( $session_sponsors ) ); ?></div>
	</div>
</div>
<?php else : ?>
	<span class="no-info"></span>
<?php endif; ?>
