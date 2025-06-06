<?php
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ($comments_number === 1) {
                printf('Un comentario en "%s"', get_the_title());
            } else {
                printf('%s comentarios en "%s"', number_format_i18n($comments_number), get_the_title());
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size' => 50,
            ));
            ?>
        </ol>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav class="comment-navigation" role="navigation">
                <div class="nav-previous"><?php previous_comments_link('← Comentarios anteriores'); ?></div>
                <div class="nav-next"><?php next_comments_link('Comentarios más recientes →'); ?></div>
            </nav>
        <?php endif; ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number()) : ?>
        <p class="no-comments">Los comentarios están cerrados.</p>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply'          => 'Deja un comentario',
        'title_reply_to'       => 'Responder a %s',
        'cancel_reply_link'    => 'Cancelar respuesta',
        'label_submit'         => 'Publicar comentario',
        'class_submit'         => 'btn btn-primary',
    ));
    ?>
</div>