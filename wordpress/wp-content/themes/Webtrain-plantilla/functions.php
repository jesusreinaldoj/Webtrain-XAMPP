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