<?php
/**
 * File for admin functions.
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
		echo '<a id="tips-and-tricks-media-modal-button" href="#" class="button tips-and-tricks-show-tip" data-editor="' . esc_attr( $editor_id ) . '" title="' . esc_attr__( 'Show Tips', 'tips-and-tricks' ) . '"><span class="tips-and-tricks-admin-button-icon dashicons-before dashicons-welcome-write-blog"></span>' . __( 'Show Tips', 'tips-and-tricks' ) . '</a>';
	}

}
add_action( 'media_buttons', 'tips_and_tricks_media_buttons', 11 );

/**
 * Config popup media modal window when the "Show Tips" media button is clicked.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function tips_and_tricks_popup_content() {

	/* Term data from 'tip_and_trick_category'. */
	$tips_and_tricks_term_data = array();
	$terms = get_terms( 'tip_and_trick_category' );
	if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$tips_and_tricks_term_data[ $term->term_id ] = $term->name;
		}
	}
	?>
	<div id="tips-and-tricks-default-ui-wrapper" class="tips-and-tricks-default-ui-wrapper" style="display: none;">
		<div class="tips-and-tricks-default-ui tips-and-tricks-image-meta">
			<div class="media-modal wp-core-ui">
				<a class="media-modal-close" href="#"><span class="media-modal-icon"><span class="screen-reader-text"><?php _e( 'Close', 'tips-and-trick' ); ?></span></span></a>
					<div class="media-modal-content">
						<div class="media-frame wp-core-ui tips-and-tricks-meta-wrap">
							<div class="media-frame-menu">
								<div id="tips-and-tricks-category" class="media-menu">
									<a href="#" class="media-menu-item">Yyyy</a>
									<a href="#" class="media-menu-item">Yyyy</a>
									<a href="#" class="media-menu-item">Yyyy</a>
								</div>
							</div>
							
							<div class="media-frame-title">
								<h1><?php _e( 'Tips', 'tips-and-tricks' ); ?></h1>
							</div>

							<?php /* Term links (tabs). */ ?>
							<div class="media-frame-router">
								<div id="tips-and-tricks-terms" class="media-router">
								<?php
								foreach ( $tips_and_tricks_term_data as $term_id => $term_name ) {
									echo '<a href="#tips-and-tricks-term-' . $term_id . '" data-tip-id="' . $term_id . '" class="media-menu-item">' . $term_name . '</a>';
								}
								?>
								</div>
							</div>

							<div class="media-frame-content">
								<div class="attachments-browser">
									<span class="spinner" id="tips-and-tricks-loading"></span>
								
									<div class="tips-and-tricks-content-area attachments">
										<div class="tips-and-tricks-content-area-wrapper">

											<?php /* Welcome message/default content. */ ?>
											<div id="tips-and-tricks-welcome" class="tips-and-tricks-section">
												<h1><?php _e( 'How to use tips?', 'tips-and-tricks' ); ?></h1>
												<ol class="tips-and-tricks-welcome-list">
													<li><?php _e( 'Select a category from above to view tips.', 'tips-and-tricks' ); ?></li>
													<li><?php _e( 'Click the tip title.', 'tips-and-tricks' ); ?></li>
													<li><?php _e( 'Click arrow up next the title to get back table of contents.', 'tips-and-tricks' ); ?></li>
												</ol>
											</div>
										
											<?php /* Create empty div as placeholder for each category. */ ?>
											<?php
											foreach ( $tips_and_tricks_term_data as $term_id => $term_name ) {
												echo '<div id="tips-and-tricks-term-' . $term_id . '" class="tips-and-tricks-section"></div>';
											}
											?>
										
										</div><!-- .tips-and-tricks-content-area-wrapper -->
									</div><!-- .attachments -->

									<div class="media-sidebar">
										<div class="tips-and-tricks-meta-sidebar">
											<h3><?php _e( 'Helpful Tips', 'tips-and-tricks' ); ?></h3>
											<strong><?php _e( 'How to read tips?', 'tips-and-tricks' ); ?></strong>
											<p><?php _e( 'To read your help tip, simply click the link in table of contents.', 'tips-and-tricks' ); ?></p>
											<strong><?php _e( 'How to filter tips?', 'tips-and-tricks' ); ?></strong>
											<p><?php _e( 'Click the category links to see tips from that category.', 'tips-and-tricks' ); ?></p>
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
