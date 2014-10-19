<?php
/**
 * File for admin functions.
 *
 * @link       https://foxland.fi
 * @since      1.0.0
 *
 * @package    Tips_And_Tricks
 * @subpackage Includes
 * @since      1.0.0
 * @author     Sami Keijonen <sami.keijonen@foxnet.fi>
 * @copyright  Copyright (c) 2014, Sami Keijonen
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Displays a link to the media modal popup containing tips and tricks.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $editor_id
 * @return void
 */
function tips_and_tricks_media_buttons( $editor_id ) {

	global $post;

	if ( is_object( $post ) && !empty( $post->post_type ) && 'tip_and_trick' !== $post->post_type ) {
		//echo '<a href="#TB_inline?width=480&amp;height=530&amp;inlineId=tips-and-tricks-popup" class="button-secondary thickbox" data-editor="' . esc_attr( $editor_id ) . '" title="' . esc_attr__( 'Show Tips', 'tips-and-tricks' ) . '">' . __( 'Show Tips', 'tips-and-tricks' ) . '</a>';
		echo '<a id="tips-and-tricks-media-modal-button" href="#" class="button tips-and-tricks-show-tip" data-editor="' . esc_attr( $editor_id ) . '" title="' . esc_attr__( 'Show Tips', 'tips-and-tricks' ) . '">' . __( 'Show Tips', 'tips-and-tricks' ) . '</a>';
		
		// @TODO: Is dashicon helpful before text Show Tips?
	
	}

}
add_action( 'media_buttons', 'tips_and_tricks_media_buttons', 11 );

/**
 * Media modal popup when the 'Show Tips' media button is clicked.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function tips_and_tricks_popup_content() {

	?>
	<div id="tips-and-tricks-default-ui-wrapper" class="tips-and-tricks-default-ui-wrapper" style="display: none;">
		<div class="tips-and-tricks-default-ui tips-and-tricks-image-meta">
			<div class="media-modal wp-core-ui">
				<a class="media-modal-close" href="#"><span class="media-modal-icon"><span class="screen-reader-text"><?php _e( 'Close', 'tips-and-trick' ); ?></span></span></a>
					<div class="media-modal-content">
						<div class="media-frame wp-core-ui tips-and-tricks-meta-wrap">
							
							<div class="media-frame-menu">
								<div class="media-menu">
									<a href="#" class="media-menu-item">Yyyy</a>
									<a href="#" class="media-menu-item">Yyyy</a>
									<a href="#" class="media-menu-item">Yyyy</a>
								</div>
							</div>
							
							<div class="media-frame-title">
                                <h1><?php _e( 'Tips', 'tips-and-tricks' ); ?></h1>
                            </div>
							
							<div class="media-frame-router">
								<div class="media-router">
								<?php
								/* Get 'tip_and_trick_category' terms and echo them. */
								$terms = get_terms( 'tip_and_trick_category' );
								if ( !empty( $terms ) && !is_wp_error( $terms ) ){
									foreach ( $terms as $term ) {
										echo '<a href="#" class="media-menu-item">' . $term->name . '</a>';
									}
								}
								?>
								</div>
							</div>
							
							<div class="media-frame-content">
								<div class="attachments-browser">
								
									<div class="tips-and-tricks-content-area attachments">
										<div class="tips-and-tricks-content-area-wrapper">
                        			
											<?php
											/* Get tip_and_trick posts. */
											$tips_and_tricks_popup_args = apply_filters( 'tips_and_tricks_popup_arguments', array(
												'post_type'      => array( 'tip_and_trick' ),
												'post_status'    => 'publish',
												'orderby'       => 'menu_order title date',
												'order'          => 'ASC',
												'posts_per_page' => -1
											) );
											
											/* Set transient (24h) for faster loading. Delete transient on hook 'save_post'. */
											if( false === ( $tips_and_tricks_popup_query = get_transient( 'tips_and_tricks_popup_query' ) ) ) {
												$tips_and_tricks_popup_query = new WP_Query( $tips_and_tricks_popup_args );
												set_transient( 'tips_and_tricks_popup_query', $tips_and_tricks_popup_query, 60*60*24 );
											}
			
											if ( $tips_and_tricks_popup_query->have_posts() ) :
				
												/* Get all the titles as table of contents and link them in posts. */
												echo '<h1 class="entry-title">' . __( 'Table of Contents', 'tips-and-tricks' ) . '</h1>';
												echo '<ul id="tips-and-tricks-table-of-contents" class="tips-and-tricks-table-of-contents">';
													while ( $tips_and_tricks_popup_query->have_posts() ) : $tips_and_tricks_popup_query->the_post(); 
						
														/* Get post slug. */
														$tips_and_tricks_post_slug = tips_and_trick_get_post_slug();
						
														the_title( '<li><a href="#' . esc_attr( $tips_and_tricks_post_slug ) . '" class="entry-title-link">', '</a></li>' );
						
													endwhile;
												echo '</ul>';

												while ( $tips_and_tricks_popup_query->have_posts() ) : $tips_and_tricks_popup_query->the_post(); 
					
													/* Get post slug. */
													$tips_and_tricks_post_slug = tips_and_trick_get_post_slug();
													?>

													<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
														<header class="entry-header">
															<?php the_title( '<h1 class="entry-title" id="' . esc_attr( $tips_and_tricks_post_slug ) . '">', ' <a href="#tips-and-tricks-table-of-contents" class="tips-and-tricks-arrow-up">' . _x( '&uarr;', 'Arrow up', 'tips-and-tricks' ) . '</a></h1>' ); ?>
														</header><!-- .entry-header -->

														<div class="entry-content">
															<?php the_content(); ?>
														</div><!-- .entry-content -->

													</article><!-- #post-## -->

												<?php endwhile; // End while loop. ?>

											<?php endif; // End check for posts. ?>
			
											<?php wp_reset_postdata(); // reset query. ?>
				
										</div><!-- .tips-and-tricks-content-area-wrapper -->
									</div><!-- .attachments -->
									
									<div class="media-sidebar">
										<div class="tips-and-tricks-meta-sidebar">
											<h3 style="margin: 1.4em 0 1em;"><?php _e( 'Helpful Tips', 'tips-and-tricks' ); ?></h3>
											<strong><?php _e( 'How to read tips?', 'tips-and-tricks' ); ?></strong>
											<p style="margin: 0 0 1.5em;"><?php _e( 'To read your help tip, simply click the link in table of contents.', 'tips-and-tricks' ); ?></p>
											<strong><?php _e( 'How to filter tips?', 'tips-and-tricks' ); ?></strong>
											<p style="margin: 0 0 1.5em;"><?php _e( 'I am working on it. Right now the category links do not work.', 'tips-and-tricks' ); ?></p>
										</div><!-- .tips-and-tricks-meta-sidebar -->
									</div><!-- .media-sidebar -->
									
								</div><!-- .attachments-browser -->
							</div><!-- .media-frame-content -->
							
							<div class="media-frame-toolbar">
								<div class="media-toolbar">
									<div class="media-toolbar-secondary">
										<a href="#" class="tips-and-tricks-close-modal button media-button button-large button-secondary media-button-insert" title="<?php esc_attr_e( 'Close', 'tips-and-tricks' ); ?>"><?php _e( 'Close', 'tips-and-tricks' ); ?></a>
									</div><!-- .media-toolbar-secondary -->
								</div><!-- .media-toolbar -->
							</div><!-- .media-frame-toolbar -->
							
						</div><!-- .media-frame -->
					</div><!-- .media-modal-content -->
				</div><!-- .media-modal -->
                
				<div class="media-modal-backdrop"></div>
				
		</div><!-- #tips-and-tricks-default-ui -->
	</div><!-- #tips-and-tricks-default-ui-wrapper -->
	<?php
	
}
add_action( 'admin_footer-post-new.php', 'tips_and_tricks_popup_content' );
add_action( 'admin_footer-post.php',     'tips_and_tricks_popup_content' );

/**
 * Get post slug.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function tips_and_trick_get_post_slug() {
	
	$tips_and_tricks_post = get_post( get_the_ID() ); 
	$tips_and_tricks_post_slug = $tips_and_tricks_post->post_name;
	
	return $tips_and_tricks_post_slug;

}

/**
 * Flush out the transients used in WP Queries.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function tips_and_tricks_transient_flusher() {
	delete_transient( 'tips_and_tricks_popup_query' );
}
add_action( 'save_post', 'tips_and_tricks_transient_flusher' );