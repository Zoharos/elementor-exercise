<?php
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