<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php bloginfo('name'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color: #ffe6e6;">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="<?php echo esc_url(home_url()); ?>"><?php bloginfo('name'); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'header-menu',
                    'container' => false,
                    'menu_class' => 'navbar-nav ms-auto',
                    'depth' => 2,
                    'fallback_cb' => false,
                    'walker'      => new WP_Bootstrap_Navwalker()
                ));
                ?>
            </div>
        </div>
    </nav>