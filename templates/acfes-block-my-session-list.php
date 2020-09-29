<?php // Session List
$class_name = 'acfes_module_meta acfes_session_list widget';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
$sessions = get_field( 'acfes_sessions', get_the_ID() );

if ( $sessions ) : ?>
<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="entry-meta block-meta">
		<h3><?php esc_html_e( 'Sessions', 'acfes' ); ?></h3>
			<div class="sessions"><?php echo wp_kses_post( acfes_get_post_object_url_list( $sessions ) ); ?></div>
	</div>
</div>
<?php else : ?>
	<span class="no-info"></span>
<?php endif; ?>
