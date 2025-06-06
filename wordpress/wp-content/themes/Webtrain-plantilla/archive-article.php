<?php get_header(); ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Noticias Personalizadas</h1>

    <?php if (have_posts()) : ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php while (have_posts()) : the_post(); ?>
                <div class="col">
                    <div class="card h-100">
                        <?php if (get_post_meta(get_the_ID(), 'urlToImage', true)) : ?>
                            <img src="<?php echo esc_url(get_post_meta(get_the_ID(), 'urlToImage', true)); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php the_title(); ?></h5>
                            <p class="card-text"><strong>Autor:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'author', true)); ?></p>
                            <p class="card-text"><strong>Descripción:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'description', true)); ?></p>
                            <p class="card-text"><strong>Fecha de publicación:</strong>
                                <?php
                                $fecha = get_post_meta(get_the_ID(), 'publishedAt', true);
                                if ($fecha) {
                                    $fecha_obj = new DateTime($fecha);
                                    echo esc_html($fecha_obj->format('d/m/Y H:i'));
                                }
                                ?>
                            </p>
                            <p class="card-text"><?php the_excerpt(); ?></p>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo esc_url(get_post_meta(get_the_ID(), 'url', true)); ?>" class="btn btn-primary" target="_blank">Leer más</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="mt-4">
            <?php
            // Paginación
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('« Anterior', 'textdomain'),
                'next_text' => __('Siguiente »', 'textdomain'),
            ));
            ?>
        </div>
    <?php else : ?>
        <p class="text-center">No se encontraron noticias personalizadas.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>