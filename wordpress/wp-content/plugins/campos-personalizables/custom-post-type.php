<?php
/*
Plugin Name: Noticias Personalizadas
Description: Plugin hecho por Webtrain para añadir noticias por api
Author: Webtrain
*/
// Hook ht_custom_post_custom_article() to the init action hook
add_action( 'init', 'ht_custom_post_custom_article' );
// The custom function to register a custom article post type
function ht_custom_post_custom_article() {
    // Set the labels. This variable is used in the $args array
    $labels = array(
        'name'               => __( 'Noticias' ),
        'singular_name'      => __( 'Noticia' ),
        'add_new'            => __( 'Añadir noticia' ),
        'add_new_item'       => __( 'Añadir noticia personalizada' ),
        'edit_item'          => __( 'Editar noticia personalizada' ),
        'new_item'           => __( 'Nueva noticia personalizada' ),
        'all_items'          => __( 'Todas las noticias' ),
        'view_item'          => __( 'Ver noticia '),
        'search_items'       => __( 'Buscar noticia personalizada' ),
        'featured_image'     => 'Poster',
        'set_featured_image' => 'Add Poster'
    );
// The arguments for our post type, to be entered as parameter 2 of register_post_type()
    $args = array(
        'labels'            => $labels,
        'description'       => 'Holds our custom article post specific data',
        'public'            => true,
        'menu_position'     => 5,
        'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
        'has_archive'       => true,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'query_var'         => true,
    );
    // Call the actual WordPress function
    // Parameter 1 is a name for the post type
    // Parameter 2 is the $args array
    register_post_type('article', $args);
}

// Registra metadatos personalizados para el post type 'article'
function ht_registrar_metadatos_article() {
    $campos = ['author', 'description', 'url', 'urlToImage', 'publishedAt', 'content'];

    foreach ($campos as $campo) {
        register_post_meta('article', $campo, array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true, // Necesario para la API REST
        ));
    }
}
add_action('init', 'ht_registrar_metadatos_article');

// Añadir la metabox al editor de 'article'
function ht_agregar_meta_box_article() {
    add_meta_box(
        'ht_article_meta_box',         // ID de la metabox
        'Información adicional de la noticia', // Título
        'ht_contenido_meta_box_article', // Callback para mostrar el contenido
        'article',                      // Post type donde se mostrará
        'normal',                       // Posición
        'high'                          // Prioridad
    );
}
add_action('add_meta_boxes', 'ht_agregar_meta_box_article');

function ht_contenido_meta_box_article($post) {
    // Seguridad: nonce para validación al guardar
    wp_nonce_field(basename(__FILE__), 'ht_article_nonce');

    // Obtener valores actuales (si existen)
    $campos = [
        'author' => 'Autor',
        'description' => 'Descripción',
        'url' => 'URL de la noticia',
        'urlToImage' => 'URL de la imagen',
        'publishedAt' => 'Fecha de publicación',
        'content' => 'Contenido completo'
    ];

    echo '<table class="form-table">';

    foreach ($campos as $campo => $label) {
        $valor = esc_attr(get_post_meta($post->ID, $campo, true));
        echo '<tr>';
        echo "<th><label for='{$campo}'>{$label}</label></th>";
        echo "<td><input type='text' style='width:100%' name='{$campo}' id='{$campo}' value='{$valor}' /></td>";
        echo '</tr>';
    }

    echo '</table>';
}

function ht_guardar_metadatos_article($post_id) {
    // Verificar nonce
    if (!isset($_POST['ht_article_nonce']) || !wp_verify_nonce($_POST['ht_article_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // Verificar autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;

    // Verificar permisos
    if (!current_user_can('edit_post', $post_id)) return $post_id;

    // Guardar cada campo
    $campos = ['author', 'description', 'url', 'urlToImage', 'publishedAt', 'content'];

    foreach ($campos as $campo) {
        if (isset($_POST[$campo])) {
            update_post_meta($post_id, $campo, sanitize_text_field($_POST[$campo]));
        }
    }
}
add_action('save_post', 'ht_guardar_metadatos_article');

function ht_importar_noticias_desde_api() {
    $url = 'https://newsapi.org/v2/everything?q=fitness&apiKey=c61fbc34a413458bb22d99412d0819c1';

    $respuesta = wp_remote_get($url, array(
        'headers' => array(
            'User-Agent' => 'MiPluginNoticias/1.0 (http://localhost/wordpress)'
        )
    ));

    if (is_wp_error($respuesta)) {
        error_log('Error al obtener datos de la API: ' . $respuesta->get_error_message());
        return;
    }

    $cuerpo = wp_remote_retrieve_body($respuesta);
    $datos = json_decode($cuerpo, true);

    error_log('Respuesta API completa: ' . print_r($datos, true));

    if (!isset($datos['articles'])) {
        error_log('Respuesta inesperada de la API. No se encontró "articles".');
        return;
    }

    foreach ($datos['articles'] as $noticia) {
        // Verificamos si ya existe un post con esa URL (para evitar duplicados)
        $existe = new WP_Query([
            'post_type' => 'article',
            'meta_key' => 'url',
            'meta_value' => $noticia['url'],
            'posts_per_page' => 1
        ]);

        if ($existe->have_posts()) {
            continue; // Saltamos si ya existe
        }

        error_log('Insertando: ' . $noticia['title']);

        $post_id = wp_insert_post([
            'post_title'  => wp_strip_all_tags($noticia['title']),
            'post_type'   => 'article',
            'post_status' => 'publish',
            'post_content'=> $noticia['content'] ?? '',
        ]);

        if (!is_wp_error($post_id)) {
            update_post_meta($post_id, 'author', $noticia['author'] ?? '');
            update_post_meta($post_id, 'description', $noticia['description'] ?? '');
            update_post_meta($post_id, 'url', $noticia['url'] ?? '');
            update_post_meta($post_id, 'urlToImage', $noticia['urlToImage'] ?? '');
            update_post_meta($post_id, 'publishedAt', $noticia['publishedAt'] ?? '');
            update_post_meta($post_id, 'content', $noticia['content'] ?? '');
        }
    }
}



add_action('admin_init', function() {
    if (current_user_can('manage_options') && isset($_GET['importar_noticias'])) {
        error_log('Probando log desde admin_init'); // <- prueba
        ht_importar_noticias_desde_api();
        echo '<div class="notice notice-success is-dismissible"><p>Noticias importadas correctamente desde la API.</p></div>';
    }
});

// Hook que se ejecutará cada hora
add_action('ht_cron_importar_noticias', 'ht_importar_noticias_desde_api');

// Activar cron al activar el plugin
register_activation_hook(__FILE__, 'ht_activar_cron');
function ht_activar_cron() {
    if (!wp_next_scheduled('ht_cron_importar_noticias')) {
        wp_schedule_event(time(), 'hourly', 'ht_cron_importar_noticias');
    }
}

// Desactivar cron al desactivar el plugin
register_deactivation_hook(__FILE__, 'ht_desactivar_cron');
function ht_desactivar_cron() {
    $timestamp = wp_next_scheduled('ht_cron_importar_noticias');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'ht_cron_importar_noticias');
    }
}

