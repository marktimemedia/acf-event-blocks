<?php // Speaker List
$class_name = 'acfes_module_meta acfes_speaker_list widget';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
$session_speakers = get_field( 'acfes_session_speakers', get_the_ID() );

if ( $session_speakers ) : ?>
<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="entry-meta block-meta">
		<h3><?php esc_html_e( 'Speakers', 'acfes' ); ?></h3>
			<div class="session-speakers"><?php echo wp_kses_post( acfes_get_post_object_image_list( $session_speakers ) ); ?></div>
	</div>
</div>
<?php else : ?>
	<span class="no-info"></span>
<?php endif; ?>
