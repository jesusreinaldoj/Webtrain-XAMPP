<?php

function mitema_enqueue_styles() {
    // Carga el style.css principal
    wp_enqueue_style('mitema-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'mitema_enqueue_styles');

function webtrain_register_menus() {
    register_nav_menus(array(
        'header-menu' => __('Menú Principal', 'webtrain'),
    ));
}
add_action('init', 'webtrain_register_menus');

/**
 * Register Custom Navigation Walker
 */
function register_navwalker(){
	require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );

function cargar_estilos_um_si_faltan() {
    if (function_exists('um_enqueue_styles')) {
        um_enqueue_styles();
    }
}
add_action('wp_enqueue_scripts', 'cargar_estilos_um_si_faltan');

function webtrain_theme_setup() {
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo');
    add_theme_support('custom-header');
    add_theme_support('custom-background');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'webtrain_theme_setup');