<?php
/**
 * File for registering custom taxonomies.
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

function tips_and_tricks_register_taxonomies() {

	/* Register the Tips and Tricks Category taxonomy. */

	register_taxonomy(
		'tip_and_trick_category',
		array( 'tip_and_trick' ),
		array(
			'public'            => true,
			'show_ui'           => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'query_var'         => 'tip_and_trick_category',

			/* Capabilities. */
			'capabilities' => array(
				'manage_terms' => 'manage_tips_and_tricks',
				'edit_terms'   => 'manage_tips_and_tricks',
				'delete_terms' => 'manage_tips_and_tricks',
				'assign_terms' => 'edit_tips_and_tricks',
			),

			/* The rewrite handles the URL structure. */
			'rewrite' => array(
				'slug'         => 'tip-and-trick/category',
				'with_front'   => false,
				'hierarchical' => true,
				'ep_mask'      => EP_NONE
			),

			/* Labels used when displaying taxonomy and terms. */
			'labels' => array(
				'name'                       => __( 'Tips and tricks Categories', 'tips-and-tricks' ),
				'singular_name'              => __( 'Tips and tricks Category',   'tips-and-tricks' ),
				'menu_name'                  => __( 'Categories',         'tips-and-tricks' ),
				'name_admin_bar'             => __( 'Category',           'tips-and-tricks' ),
				'search_items'               => __( 'Search Categories',  'tips-and-tricks' ),
				'popular_items'              => __( 'Popular Categories', 'tips-and-tricks' ),
				'all_items'                  => __( 'All Categories',     'tips-and-tricks' ),
				'edit_item'                  => __( 'Edit Category',      'tips-and-tricks' ),
				'view_item'                  => __( 'View Category',      'tips-and-tricks' ),
				'update_item'                => __( 'Update Category',    'tips-and-tricks' ),
				'add_new_item'               => __( 'Add New Category',   'tips-and-tricks' ),
				'new_item_name'              => __( 'New Category Name',  'tips-and-tricks' ),
				'parent_item'                => __( 'Parent Category',    'tips-and-tricks' ),
				'parent_item_colon'          => __( 'Parent Category:',   'tips-and-tricks' ),
				'separate_items_with_commas' => null,
				'add_or_remove_items'        => null,
				'choose_from_most_used'      => null,
				'not_found'                  => null,
			)
		)
	);

	/* Register the Portfolio Tag taxonomy. */

	register_taxonomy(
		'tip_and_trick_tag',
		array( 'tip_and_trick' ),
		array(
			'public'            => true,
			'show_ui'           => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'show_admin_column' => true,
			'hierarchical'      => false,
			'query_var'         => 'tip_and_trick_tag',

			/* Capabilities. */
			'capabilities' => array(
				'manage_terms' => 'manage_tips_and_tricks',
				'edit_terms'   => 'manage_tips_and_tricks',
				'delete_terms' => 'manage_tips_and_tricks',
				'assign_terms' => 'edit_tips_and_tricks',
			),

			/* The rewrite handles the URL structure. */
			'rewrite' => array(
				'slug'         => 'tip-and-trick/tag',
				'with_front'   => false,
				'hierarchical' => false,
				'ep_mask'      => EP_NONE
			),

			/* Labels used when displaying taxonomy and terms. */
			'labels' => array(
				'name'                       => __( 'Tips and tricks Tags',                   'tips-and-tricks' ),
				'singular_name'              => __( 'Tips and tricks Tag',                    'tips-and-tricks' ),
				'menu_name'                  => __( 'Tags',                           'tips-and-tricks' ),
				'name_admin_bar'             => __( 'Tag',                            'tips-and-tricks' ),
				'search_items'               => __( 'Search Tags',                    'tips-and-tricks' ),
				'popular_items'              => __( 'Popular Tags',                   'tips-and-tricks' ),
				'all_items'                  => __( 'All Tags',                       'tips-and-tricks' ),
				'edit_item'                  => __( 'Edit Tag',                       'tips-and-tricks' ),
				'view_item'                  => __( 'View Tag',                       'tips-and-tricks' ),
				'update_item'                => __( 'Update Tag',                     'tips-and-tricks' ),
				'add_new_item'               => __( 'Add New Tag',                    'tips-and-tricks' ),
				'new_item_name'              => __( 'New Tag Name',                   'tips-and-tricks' ),
				'separate_items_with_commas' => __( 'Separate tags with commas',      'tips-and-tricks' ),
				'add_or_remove_items'        => __( 'Add or remove tags',             'tips-and-tricks' ),
				'choose_from_most_used'      => __( 'Choose from the most used tags', 'tips-and-tricks' ),
				'not_found'                  => __( 'No tags found',                  'tips-and-tricks' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
			)
		)
	);
}
add_action( 'init', 'tips_and_tricks_register_taxonomies' );