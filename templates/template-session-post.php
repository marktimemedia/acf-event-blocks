<?php
/**
 * The template for displaying the single session posts
 *
 * @package acf_event_schedule
 * @since 1.0.0
 */

acfes_load_wrap_header(); ?>
<section class="content--page">

<?php if ( ! post_password_required( $post ) ) : ?>

		<?php
		/* Start the Loop */
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="post--content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->

				<?php if ( get_option( 'acfes_base_url' ) ) { ?>
					<footer class="entry-footer">
						<p><a href="<?php echo esc_url( get_option( 'acfes_base_url' ) ); ?>">
							<?php esc_html_e( 'Return to Schedule', 'acfes' ); ?>
						</a></p>
					</footer>
				<?php } ?>

			</article><!-- #post-${ID} -->

			<?php	endwhile; // End of the loop. ?>
		<?php endif; ?>
	</section>
<?php
acfes_load_wrap_footer();
