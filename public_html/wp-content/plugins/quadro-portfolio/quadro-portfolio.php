<?php
/*
Plugin Name: Quadro Portfolio Type
Description: Registers Quadro's Portfolio post type.
Version: 1.0.0
Author: Quadro Ideas
Author URI: http://quadroideas.com
*/


function quadro_portfolio_register() {

   /**
    * Register quadro_portfolio custom post type
    */
    // Retrieve Theme Options if there are.
    $quadro_options = get_option( 'quadro_newone_options' );
    $quadro_portfolio_slug = ( $quadro_options != false && isset($quadro_options['portfolio_slug']) && $quadro_options['portfolio_slug'] != '' ) ? $quadro_options['portfolio_slug'] : 'portfolio-item';
    register_post_type( 'quadro_portfolio', array(
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => $quadro_portfolio_slug ),
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'revisions' ),
        'capability_type' => 'post',
        'capabilities' => array(),
        'taxonomies' => array('portfolio_tax'),
        'menu_icon'=> 'dashicons-portfolio',
        'labels' => array(
            'name' => __( 'Portfolio Items', 'quadro' ),
            'singular_name' => __( 'Portfolio Item', 'quadro' ),
            'add_new' => __( 'Add New Item', 'quadro' ),
            'add_new_item' => __( 'Add New Portfolio Item', 'quadro' ),
            'edit_item' => __( 'Edit Portfolio Item', 'quadro' ),
            'new_item' => __( 'New Portfolio Item', 'quadro' ),
            'all_items' => __( 'All Portfolio Items', 'quadro' ),
            'view_item' => __( 'View Portfolio Item', 'quadro' ),
            'search_items' => __( 'Search Portfolio Items', 'quadro' ),
            'not_found' =>  __( 'No Portfolio Items found', 'quadro' ),
            'not_found_in_trash' => __( 'No Portfolio Items found in Trash', 'quadro' ),
            'parent_item_colon' => '',
            'menu_name' => 'Portfolio'
        )
    ) );
}
add_action( 'init', 'quadro_portfolio_register' );


/**
 * Register Portfolio Taxonomy
 */
function quadro_portfolio_taxonomies() {

    // Register Portfolio Categories
    $labels = array(
        'name'              => __( 'Portfolio Categories', 'quadro' ),
        'singular_name'     => __( 'Portfolio Category', 'quadro' ),
        'search_items'      => __( 'Search Portfolio Categories', 'quadro' ),
        'all_items'         => __( 'All Portfolio Categories', 'quadro' ),
        'parent_item'       => __( 'Parent Portfolio Category', 'quadro' ),
        'parent_item_colon' => __( 'Parent Portfolio Category:', 'quadro' ),
        'edit_item'         => __( 'Edit Portfolio Category', 'quadro' ),
        'update_item'       => __( 'Update Portfolio Category', 'quadro' ),
        'add_new_item'      => __( 'Add Portfolio Category', 'quadro' ),
        'new_item_name'     => __( 'New Portfolio Category Name', 'quadro' ),
        'menu_name'         => __( 'Portfolio Categories', 'quadro' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_in_nav_menus' => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => __('filter', 'quadro'), 'with_front' => false ),
    );

    register_taxonomy( 'portfolio_tax', array( 'quadro_portfolio' ), $args );

}
add_action( 'init', 'quadro_portfolio_taxonomies', 0 );


?>