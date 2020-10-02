<?php // General Meta Block Wrapper
$class_name = 'acfes_module_countdown ' . acfes_color_picker_class( 'acfes_background_color', false, true ) . ' ' . acfes_color_picker_class( 'acfes_text_color', false, false );
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

$showlive        = _get_field( 'acfes_show_live_event' ) ? true : false;
$countdown_start = get_option( 'acfes_countdown_date' ) ? get_option( 'acfes_countdown_date' ) : current_time( 'Y-m-d H:i:s' );
$countdown_end   = get_option( 'acfes_countdown_end_time' ) ? get_option( 'acfes_countdown_end_time' ) : current_time( 'Y-m-d H:i:s' );
$now             = current_time( 'Y-m-d H:i:s' );
$pre_cta         = _get_field( 'acfes_pre_event_link' );
$post_cta        = _get_field( 'acfes_post_event_link' );
$acfes_term      = _get_field( 'acfes_live_event_taxonomy' );
?>

<div class="<?php echo esc_attr( $class_name ); ?>" style="background-color:<?php the_field( 'acfes_background_color' ); ?>; color:<?php the_field( 'acfes_text_color' ); ?>;">
	<div class="acfes-module--countdown-container content--inner">
		<div id="countdownclock">
			<div class="numbers">
				<span class="days">00</span>
				<div class="smalltext">Days</div>
			</div>
			<div class="numbers">
				<span class="hours">00</span>
				<div class="smalltext">Hours</div>
			</div>
			<div class="numbers">
				<span class="minutes">00</span>
				<div class="smalltext">Minutes</div>
			</div>
			<div class="numbers">
				<span class="seconds">00</span>
				<div class="smalltext">Seconds</div>
			</div>
	</div>
	<div id="infoblock">
		<div class="upcoming">
			<?php the_field( 'acfes_countdown_text' ); ?>
			<?php
			if ( $pre_cta ) {
				echo '<a class="button outline not-logged-in" style="border-color:' . esc_attr( _get_field( 'acfes_text_color' ) ) . '; color:' . esc_attr( _get_field( 'acfes_text_color' ) ) . ';" href="' . esc_url( $pre_cta['url'] ) . '">' . esc_html( $pre_cta['title'] ) . '</a>';
			}
			?>
		</div>
		<div class="announcement announce-current">
			<span><?php echo esc_html( __( 'Live Now', 'acfes' ) ); ?></span>
		</div>
		<div class="current">
			<?php
			if ( $showlive ) : // show the next upcoming event

				$next_live = acfes_upcoming_events( $countdown_start, $now, $acfes_term, 1 );

				if ( $next_live->have_posts() ) :
					while ( $next_live->have_posts() ) :
						$next_live->the_post(); // upcoming session

						$session_time     = strtotime( get_field( 'acfes_session_time', get_the_ID() ) );
						$session_end_time = strtotime( get_field( 'acfes_session_end_time', get_the_ID() ) );
						$time_format      = get_option( 'time_format', 'g:i a' );
						?>

						<section class="acfes-countdown-content">
							<strong><?php echo esc_html( __( 'Happening Now: ', 'acfes' ) . get_term( $acfes_term )->name . ' ' . get_taxonomy( get_term( $acfes_term )->taxonomy )->label ); ?></strong>
							<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<?php
							if ( $session_time && ! $session_end_time ) {
								echo '<time>At ' . esc_html( gmdate( $time_format, $session_time ) ) . ' (' . esc_html( wp_timezone_string() ) . ')</time>';
							} elseif ( $session_time && $session_end_time ) {
								echo '<time>From ' . esc_html( gmdate( $time_format, $session_time ) ) . ' to ' . esc_html( gmdate( $time_format, $session_end_time ) ) . ' (' . esc_html( wp_timezone_string() ) . ')</time>';
							}
							?>
						</section>

						<?php
					endwhile;
				else : // no upcoming sessions but still live event
					?>

						<section class="acfes-list--post-content no-sessions">
							<h4><?php echo esc_html( __( 'No Upcoming Sessions in ', 'acfes' ) . get_term( $acfes_term )->name ); ?></h4>
							<a class="button outline" style="border-color:<?php echo esc_attr( _get_field( 'acfes_text_color' ) ); ?>; color:<?php echo esc_attr( _get_field( 'acfes_text_color' ) ); ?>;" href="<?php echo esc_url( get_option( 'acfes_base_url' ) ); ?>"><?php echo esc_html( __( 'View Schedule', 'acfes' ) ); ?></a>
						</section>

					<?php
				endif;
				wp_reset_postdata();
			else :
				?>
				<?php the_field( 'acfes_countdown_text' ); // default to showing the upcoming text ?>
			<?php endif; ?>
			</div>
			<div class="announcement announce-past">
				<span><?php esc_html_e( 'Thank You!', 'acfes' ); ?></span>
			</div>
			<div class="past">
				<?php the_field( 'acfes_event_passed_text' ); ?>
				<?php
				if ( $post_cta ) {
					echo '<a class="button outline" style="border-color:' . esc_attr( _get_field( 'acfes_text_color' ) ) . '; color:' . esc_attr( _get_field( 'acfes_text_color' ) ) . ';" href="' . esc_url( $post_cta['url'] ) . '">' . esc_html( $post_cta['title'] ) . '</a>';
				}
				?>
			</div>
		</div>
	</div>
</div>
