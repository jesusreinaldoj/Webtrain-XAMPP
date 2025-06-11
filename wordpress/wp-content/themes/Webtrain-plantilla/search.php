<?php get_header(); ?>

<main>
    <h1>Resultados de búsqueda para: "<?php echo get_search_query(); ?>"</h1>

    <?php if (have_posts()) : ?>
        <ul>
            <?php while (have_posts()) : the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    
                    <?php if (get_post_type() === 'article') : ?>
                        <p><strong>Noticia:</strong> <?php echo get_post_meta(get_the_ID(), 'description', true); ?></p>
                    <?php else : ?>
                        <p><?php the_excerpt(); ?></p>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
