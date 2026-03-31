<?php get_header(); ?>

<div class="main-wrapper">

    <?php get_sidebar(); ?>

    <div class="content-box">
        <div class="content-header">
            <h2 class="content-title">
                Результаты поиска: «<?php echo esc_html( get_search_query() ); ?>»
            </h2>
            <div class="header-line"></div>
        </div>

        <div class="content-body">
            <?php if ( have_posts() ) : ?>
                <ul style="list-style:disc; padding-left:20px;">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <li style="margin-bottom:10px;">
                            <a href="<?php the_permalink(); ?>" style="color:#4a1d1d; font-weight:bold;">
                                <?php the_title(); ?>
                            </a>
                            <p style="margin:4px 0 0;"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <?php the_posts_pagination(); ?>
            <?php else : ?>
                <p>По запросу «<?php echo esc_html( get_search_query() ); ?>» ничего не найдено.</p>
                <?php get_search_form(); ?>
            <?php endif; ?>
        </div>
    </div>

    <?php get_template_part( 'template-parts/aside-posters' ); ?>

</div>

<?php get_footer(); ?>
