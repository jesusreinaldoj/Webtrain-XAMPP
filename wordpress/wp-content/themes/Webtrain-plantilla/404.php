<?php get_header(); ?>

<div class="main-container">
    <!-- PANEL IZQUIERDO -->
    <div class="left-panel">
        <h1>¡Página no encontrada!</h1>
        <p>Lo sentimos, pero la página que buscas no existe o ha sido movida.</p>
        <a href="<?php echo home_url(); ?>" class="btn btn-primary">Volver al inicio</a>
    </div>

    <!-- PANEL DERECHO -->
    <div class="right-panel">
        <img src="<?php echo get_template_directory_uri(); ?>/IMG/404-image.png" class="imagen-404" alt="Página no encontrada">
    </div>
</div>

<?php get_footer(); ?>