<?php get_header(); ?>

<div class="main-wrapper">

    <?php get_sidebar(); ?>

    <div class="content-box">
        <?php
        // На главной — показываем первый опубликованный раздел летописи
        $first = get_posts( array(
            'post_type'      => 'letopis_section',
            'posts_per_page' => 1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'post_status'    => 'publish',
        ) );

        if ( $first ) {
            $post = $first[0];
            setup_postdata( $post );
            ?>
            <div class="content-header">
                <h2 class="content-title"><?php echo esc_html( get_the_title( $post ) ); ?></h2>
                <div class="header-line"></div>
            </div>
            <div class="content-body">
                <?php echo apply_filters( 'the_content', get_the_content( null, false, $post ) ); ?>
            </div>
            <?php
            wp_reset_postdata();
        } else {
            // Страница по умолчанию, если разделов ещё нет
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    ?>
                    <div class="content-header">
                        <h2 class="content-title"><?php the_title(); ?></h2>
                        <div class="header-line"></div>
                    </div>
                    <div class="content-body">
                        <?php the_content(); ?>
                    </div>
                    <?php
                endwhile;
            else :
                echo '<p>Добро пожаловать! Добавьте разделы летописи в панели администратора.</p>';
            endif;
        }
        ?>
    </div><!-- /.content-box -->

    <?php get_template_part( 'template-parts/aside-posters' ); ?>

</div><!-- /.main-wrapper -->

<?php get_footer(); ?>
