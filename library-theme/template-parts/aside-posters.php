<?php
/**
 * Правая колонка с афишами.
 * Выводит записи типа «poster» с миниатюрой и ссылкой (поле _poster_url).
 */
$posters = get_posts( array(
    'post_type'      => 'poster',
    'posts_per_page' => 6,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_status'    => 'publish',
) );
?>

<aside class="aside-posters">
    <?php if ( $posters ) : ?>
        <?php foreach ( $posters as $poster ) : ?>
            <?php
            $url = get_post_meta( $poster->ID, '_poster_url', true );
            $img = get_the_post_thumbnail_url( $poster->ID, 'medium_large' );
            ?>
            <?php if ( $img ) : ?>
            <div class="poster-card">
                <?php if ( $url ) : ?>
                    <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener">
                <?php endif; ?>
                    <img src="<?php echo esc_url( $img ); ?>"
                         alt="<?php echo esc_attr( get_the_title( $poster ) ); ?>">
                <?php if ( $url ) : ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else : ?>
        <!-- Если афиш ещё нет, блок просто пустой -->
    <?php endif; ?>
</aside>
