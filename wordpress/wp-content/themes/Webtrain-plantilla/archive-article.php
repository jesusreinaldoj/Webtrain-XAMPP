<?php get_header(); ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Noticias Personalizadas</h1>

    <?php 
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args = [
        'post_type' => 'article',
        'posts_per_page' => 12,
        'meta_key' => 'publishedAt',
        'orderby' => 'meta_value',
        'order' => 'DESC',
        'paged' => $paged,
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) : 
        $urls_vistos = [];
        ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            while ($query->have_posts()) : $query->the_post();
                $url = get_post_meta(get_the_ID(), 'url', true);
                if (in_array($url, $urls_vistos)) {
                    continue;
                }
                $urls_vistos[] = $url;
            ?>
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
                            <a href="<?php echo esc_url($url); ?>" class="btn btn-primary" target="_blank">Leer más</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="mt-4">
            <?php
            echo paginate_links([
                'total' => $query->max_num_pages,
                'current' => $paged,
                'mid_size' => 2,
                'prev_text' => __('« Anterior', 'textdomain'),
                'next_text' => __('Siguiente »', 'textdomain'),
            ]);
            ?>
        </div>
    <?php else : ?>
        <p class="text-center">No se encontraron noticias personalizadas.</p>
    <?php endif; 
    wp_reset_postdata();
    ?>
</div>

<?php get_footer(); ?>
