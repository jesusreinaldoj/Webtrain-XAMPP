<?php get_header(); ?>

<div class="main-container">
    <!-- PANEL IZQUIERDO -->
    <div class="left-panel">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="mb-4"><?php the_title(); ?></h1>
                    <div class="post-meta mb-3">
                        <span>Publicado el: <?php echo get_the_date(); ?></span> |
                        <span>Autor: <?php the_author(); ?></span> |
                        <span>Categorías: <?php the_category(', '); ?></span>
                    </div>
                    <div class="post-thumbnail mb-4">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('large', ['class' => 'img-fluid']);
                        } ?>
                    </div>
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>
                    <div class="post-tags mt-4">
                        <?php the_tags('<span class="badge bg-secondary me-2">', '</span><span class="badge bg-secondary me-2">', '</span>'); ?>
                    </div>
                </article>
                <div class="post-navigation mt-5">
                    <div class="d-flex justify-content-between">
                        <div class="prev-post">
                            <?php previous_post_link('%link', '← Publicación anterior'); ?>
                        </div>
                        <div class="next-post">
                            <?php next_post_link('%link', 'Siguiente publicación →'); ?>
                        </div>
                    </div>
                </div>
                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
            endwhile;
        else :
            echo '<p>No se encontraron publicaciones.</p>';
        endif;
        ?>
    </div>

    <!-- PANEL DERECHO -->
    <div class="right-panel">
        <h2>Entradas recientes</h2>
        <ul>
            <?php
            $recent_posts = wp_get_recent_posts(array('numberposts' => 5));
            foreach ($recent_posts as $post) : ?>
                <li>
                    <a href="<?php echo esc_url(get_permalink($post['ID'])); ?>">
                        <?php echo esc_html($post['post_title']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<?php get_footer(); ?>