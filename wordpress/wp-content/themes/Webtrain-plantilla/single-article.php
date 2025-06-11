<?php get_header(); ?>

<div class="container mt-5">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>

        <?php if (get_post_meta(get_the_ID(), 'urlToImage', true)) : ?>
            <img src="<?php echo esc_url(get_post_meta(get_the_ID(), 'urlToImage', true)); ?>" alt="<?php the_title(); ?>" class="img-fluid mb-3" />
        <?php endif; ?>

        <p><strong>Autor:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'author', true)); ?></p>

        <p><strong>Fecha de publicación:</strong> 
        <?php 
            $fecha = get_post_meta(get_the_ID(), 'publishedAt', true);
            if ($fecha) {
                $fecha_obj = new DateTime($fecha);
                echo esc_html($fecha_obj->format('d/m/Y H:i'));
            }
        ?>
        </p>

        <div>
            <?php the_content(); ?>
        </div>

        <p>
            <a href="<?php echo esc_url(get_post_meta(get_the_ID(), 'url', true)); ?>" target="_blank" class="btn btn-primary">
                Leer en la fuente original
            </a>
        </p>

        <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
    
        ?>

    <?php endwhile; else: ?>
        <p>No se encontró la noticia.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
