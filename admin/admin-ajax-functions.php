<?php
/**
 * File for admin ajax functions.
 *
 * @link       https://foxland.fi
 * @since      1.0.0
 *
 * @package    Tips_And_Tricks
 * @subpackage Admin
 * @since      1.0.0
 * @author     Sami Keijonen <sami.keijonen@foxnet.fi>
 * @copyright  Copyright (c) 2014, Sami Keijonen
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Function to load when clicking Tips Term.
 * This will load list of Tips Title in the Tips Term selected by user.
 *
 * @since 1.0.0
 */
function tips_and_tricks_ajax_click_term_link(){

	/* Verify nonce. */
	if ( ! wp_verify_nonce( $_POST['tips_and_tricks_ajax_nonce'], 'tips_and_tricks_ajax_nonce' ) ) {
		die(-1);
	}

	/* Get term id when clicked. */
	$term_id = absint( $_POST['tips_and_tricks_ajax_termid'] );

	/* Bail early if there is no term id set. */
	if( !isset( $term_id ) || empty( $term_id ) ) {
		die();
	}

	/* WP Query to get Tips in Tips category 'tip_and_trick_category'. */
	$tips_and_tricks_archive_query_args = array(
		'post_type'       => array( 'tip_and_trick' ),
		'orderby'         => 'menu_order title date',
		'order'           => 'ASC',
		'posts_per_page'  => -1,
		'tax_query' => array(
			array(
				'taxonomy' => 'tip_and_trick_category',
				'field'    => 'term_id',
				'terms'    => $term_id,
			),
		),
	);
	$tips_and_tricks_archive_query = new WP_Query( $tips_and_tricks_archive_query_args );

	if ( $tips_and_tricks_archive_query->have_posts() ) {
	?>

		<div id="tips-and-tricks-toc-<?php echo $term_id ?>">
			<h1 class="entry-title"><?php _e( 'Table of Contents', 'tips-and-tricks' ); ?></h1>
			<ul>
				<?php while ( $tips_and_tricks_archive_query->have_posts() ) { ?>
					<?php $tips_and_tricks_archive_query->the_post(); ?>
						<li><a href="#tips-and-tricks-<?php the_ID(); ?>"><?php the_title(); ?></a></li>
				<?php } // end while ?>
			</ul>
		</div><!-- #tips-and-tricks-toc -->

		<?php rewind_posts(); ?>

		<?php while ( $tips_and_tricks_archive_query->have_posts() ) { ?>
			<?php $tips_and_tricks_archive_query->the_post(); ?>
			<div id="tips-and-tricks-<?php the_ID(); ?>" class="tips-single">
				<h2><?php the_title() ?> <a href="#tips-and-tricks-toc-<?php echo $term_id ?>" class="add-new-h2 tips-and-tricks-arrow-up"><?php echo _x( '&uarr;', 'Arrow up', 'tips-and-tricks' ); ?></a></h2>
				<div class="tips-content">
					<?php the_content(); ?>
				</div>
			</div>
		<?php } // end while
		
	} // endif have_posts
	
	wp_reset_postdata(); // Reset query.

	/* Always do "die()" on ajax call to stop it because Ajax is like mosquito, they are persistent. */
	die();
}
add_action( 'wp_ajax_tips_and_tricks_click_term_link', 'tips_and_tricks_ajax_click_term_link' );
