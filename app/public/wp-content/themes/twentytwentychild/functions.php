<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function add_disable_admin_meta($user_id) {
    $user = get_userdata( $user_id );
    if ( $user->user_email == 'wptest@elementor.com' ) {
        add_user_meta($user_id, 'disable_admin', 'yes');
    } else {
        add_user_meta($user_id, 'disable_admin', 'no');
    }
}
add_action('user_register', 'add_disable_admin_meta');

function add_disable_admin_meta_on_login($user_login, $user) {
    if (get_metadata('user', $user->ID, 'disable_admin', true) === '') {
        if ( $user->user_email == 'wptest@elementor.com' ) {
            add_user_meta($user->ID, 'disable_admin', 'yes');
        } else {
            add_user_meta($user->ID, 'disable_admin', 'no');
        }
      } else {
        if ( $user->user_email == 'wptest@elementor.com' ) {
            update_user_meta($user->ID, 'disable_admin', 'yes');
        } else {
            update_user_meta($user->ID, 'disable_admin', 'no');
        }
      }
}
add_action('wp_login', 'add_disable_admin_meta_on_login', 10, 2);

function disable_admin_bar_for_blocked_users() {
    $user = wp_get_current_user();
    $is_admin_disabled = get_user_meta( $user->ID, 'disable_admin', true );
    if ( $user && current_user_can( 'editor' ) && $is_admin_disabled == 'yes' ) {
        show_admin_bar( false );
    }
}
add_action( 'wp', 'disable_admin_bar_for_blocked_users' );

////////////////////////////////////////////////////////////////////////////////////////////////

function register_products_post_type() {
    $labels = array(
        'name' => 'Products',
        'singular_name' => 'Product',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Product',
        'edit_item' => 'Edit Product',
        'new_item' => 'New Product',
        'view_item' => 'View Product',
        'search_items' => 'Search Products',
        'not_found' => 'No Products found',
        'not_found_in_trash' => 'No Products found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Products'
    );

    $args = array(
        'labels' => $labels,
        'description' => 'A list of products for sale',
        'public' => true,
        'menu_position' => 5,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
        'has_archive' => true,
        'taxonomies' => array('product_category'),
        'rewrite' => array('slug' => 'products'),
    );

    register_post_type( 'product', $args );
}
add_action( 'init', 'register_products_post_type' );

function register_product_category_taxonomy() {
    $labels = array(
      'name' => __('Product Categories'),
      'singular_name' => __('Product Category'),
      'menu_name' => __('Product Categories'),
      'all_items' => __('All Categories'),
      'edit_item' => __('Edit Category'),
      'view_item' => __('View Category'),
      'update_item' => __('Update Category'),
      'add_new_item' => __('Add New Category'),
      'new_item_name' => __('New Category Name'),
      'parent_item' => __('Parent Category'),
      'parent_item_colon' => __('Parent Category:'),
      'search_items' => __('Search Categories'),
      'popular_items' => __('Popular Categories'),
      'separate_items_with_commas' => __('Separate Categories with commas'),
      'add_or_remove_items' => __('Add or remove Categories'),
      'choose_from_most_used' => __('Choose from the most used Categories'),
      'not_found' => __('No Categories found.'),
      'no_terms' => __('No Categories'),
      'items_list_navigation' => __('Categories list navigation'),
      'items_list' => __('Categories list'),
      'back_to_items' => __('Back to Categories'),
    );
  
    $args = array(
      'labels' => $labels,
      'public' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'show_in_nav_menus' => true,
      'show_tagcloud' => true,
      'hierarchical' => true,
      'rewrite' => array('slug' => 'product-category'),
      'show_admin_column' => true,
    );
  
    register_taxonomy('product_category', array('product'), $args);
  }
  
  add_action('init', 'register_product_category_taxonomy');