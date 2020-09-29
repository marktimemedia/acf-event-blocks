<?php // File List
$class_name = 'acfes_module_meta acfes_file_list widget';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
$files_fieldname = 'acfes_file_repeater';
$files           = get_field( $files_fieldname, get_the_ID() );
$slides          = get_field( 'acfes_slide_link', get_the_ID() );

if ( $slides ) : ?>
<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="entry-meta block-meta">
		<h3><?php esc_html_e( 'Slides', 'acfes' ); ?></h3>
			<div class="slide-link"><a aria-label="Link to Slides" href="<?php echo esc_url( $slides ); ?>"><?php esc_html_e( 'Link to Slides', 'acfes' ); ?></a></div>
	</div>
</div>
<?php endif; ?>

<?php if ( $files ) : ?>
<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="entry-meta block-meta">
		<h3><?php esc_html_e( 'Downloads', 'acfes' ); ?></h3>
			<div class="file-downloads"><?php the_acfes_file_links( $files_fieldname, get_the_ID() ); ?></div>
	</div>
</div>
<?php endif; ?>

<?php if ( ! $files && ! $slides ) : ?>
	<span class="no-info"></span>
<?php endif; ?>
