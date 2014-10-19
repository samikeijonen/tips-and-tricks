<?php
/**
 * File for registering custom post types.
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
 * Registers post types needed by the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function tips_and_tricks_register_post_types() {

	/* Set up the arguments for the post type. */
	$tip_and_trick_args = array(
		'description'         => '',
		'public'              => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'show_in_nav_menus'   => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-welcome-write-blog',
		'can_export'          => true,
		'delete_with_user'    => false,
		'hierarchical'        => true,
		'has_archive'         => 'tips',
		'query_var'           => 'tips_and_tricks',
		'capability_type'     => 'tips_and_tricks',
		'map_meta_cap'        => true,

		'capabilities' => array(

			// meta caps (don't assign these to roles)
			'edit_post'              => 'edit_tip_and_trick',
			'read_post'              => 'read_tip_and_trick',
			'delete_post'            => 'delete_tip_and_trick',

			// primitive/meta caps
			'create_posts'           => 'create_tips_and_trick',

			// primitive caps used outside of map_meta_cap()
			'edit_posts'             => 'edit_tips_and_tricks',
			'edit_others_posts'      => 'manage_tip_and_trick',
			'publish_posts'          => 'manage_tip_and_trick',
			'read_private_posts'     => 'read',

			// primitive caps used inside of map_meta_cap()
			'read'                   => 'read',
			'delete_posts'           => 'manage_tip_and_trick',
			'delete_private_posts'   => 'manage_tip_and_trick',
			'delete_published_posts' => 'manage_tip_and_trick',
			'delete_others_posts'    => 'manage_tip_and_trick',
			'edit_private_posts'     => 'edit_tips_and_tricks',
			'edit_published_posts'   => 'edit_tips_and_tricks'
		),

		'rewrite' => array(
			'slug'       => 'tip',
			'with_front' => false,
			'pages'      => false,
			'feeds'      => true,
			'ep_mask'    => EP_PERMALINK,
		),

		'supports' => array(
			'title',
			'editor',
			'page-attributes'
		),

		'labels' => array(
			'name'               => __( 'Tips',                   'tips-and-tricks' ),
			'singular_name'      => __( 'Tip',                    'tips-and-tricks' ),
			'menu_name'          => __( 'Tips',                   'tips-and-tricks' ),
			'name_admin_bar'     => __( 'Tips',                   'tips-and-tricks' ),
			'all_items'          => __( 'Tips',                   'tips-and-tricks' ),
			'add_new'            => __( 'Add Tip',                'tips-and-tricks' ),
			'add_new_item'       => __( 'Add New Tip',            'tips-and-tricks' ),
			'edit_item'          => __( 'Edit Tip',               'tips-and-tricks' ),
			'new_item'           => __( 'New Tip',                'tips-and-tricks' ),
			'view_item'          => __( 'View Tip',               'tips-and-tricks' ),
			'search_items'       => __( 'Search Tips',            'tips-and-tricks' ),
			'not_found'          => __( 'No tips found',          'tips-and-tricks' ),
			'not_found_in_trash' => __( 'No tips found in trash', 'tips-and-tricks' ),

			/* Custom archive label.  Must filter 'post_type_archive_title' to use. */
			'archive_title'      => __( 'Tips',                   'tips-and-tricks' ),
		)
	);

	/* Register post types. */
	register_post_type( 'tip_and_trick', $tip_and_trick_args );
}
add_action( 'init', 'tips_and_tricks_register_post_types' );

/**
 * Custom "enter title here" text.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $title
 * @param  object  $post
 * @return string
 */
function tips_and_tricks_enter_title_here( $title, $post ) {

	if ( 'tip_and_trick' === $post->post_type )
		$title = __( 'Enter tip name', 'tips-and-tricks' );

	return $title;
}
add_filter( 'enter_title_here', 'tips_and_tricks_enter_title_here', 10, 2 );

/**
 * @since  1.0.0
 * @access public
 * @return void
 */
function tips_and_tricks_post_updated_messages( $messages ) {
	global $post, $post_ID;

	$messages['tip_and_trick'] = array(
		 0 => '', // Unused. Messages start at index 1.
		 1 => sprintf( __( 'Tip updated. <a href="%s">View tip</a>', 'tips-and-tricks' ), esc_url( get_permalink( $post_ID ) ) ),
		 2 => '',
		 3 => '',
		 4 => __( 'Tip updated.', 'tips-and-tricks' ),
		 5 => isset( $_GET['revision'] ) ? sprintf( __( 'Tip restored to revision from %s', 'tips-and-tricks' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		 6 => sprintf( __( 'Tip published. <a href="%s">View tip</a>', 'tips-and-tricks' ), esc_url( get_permalink( $post_ID ) ) ),
		 7 => __( 'Tip saved.', 'tips-and-tricks' ),
		 8 => sprintf( __( 'Tip submitted. <a target="_blank" href="%s">Preview tip</a>', 'tips-and-tricks' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
		 9 => sprintf( __( 'Tip scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview tip</a>', 'tips-and-tricks' ), date_i18n( __( 'M j, Y @ G:i', 'tips-and-tricks' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
		10 => sprintf( __( 'Tip draft updated. <a target="_blank" href="%s">Preview tip</a>', 'tips-and-tricks' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'tips_and_tricks_post_updated_messages' );