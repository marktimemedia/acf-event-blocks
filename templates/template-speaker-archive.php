<?php
/**
 * The template for displaying the speaker archive
 *
 * @package acf_event_schedule
 * @since 1.0.0
 */
$display = ( 'option-grid' === ( get_option( 'acfes_speaker_archive_type' ) ) ) ? 'grid' : 'list';

acfes_load_wrap_header();
?>
<section class="content--page">
	<header class="page--header archive-header">
			<h1 class="page--title">
					<?php the_archive_title(); ?>
			</h1>
	</header>
	<div class="content--inner">
		<div class="acfes-module--<?php echo esc_attr( $display ) . ' ' . esc_attr( $content_type ); ?>-block">
					<?php
					while ( have_posts() ) :
						the_post();
						?>

						<?php acfes_get_block_part( 'content-' . $display, $content_type ); ?>

				<?php endwhile; ?>
			</div>
		</div>
	</section>
<?php
acfes_load_wrap_footer();
