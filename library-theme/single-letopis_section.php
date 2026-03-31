<?php get_header(); ?>

<div class="main-wrapper">

    <?php get_sidebar(); ?>

    <div class="content-box">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <div class="content-header">
                <h2 class="content-title"><?php the_title(); ?></h2>
                <div class="header-line"></div>
            </div>

            <div class="content-body">
                <?php the_content(); ?>
            </div>

            <!-- Навигация между разделами -->
            <nav class="section-nav" style="margin-top:30px; padding-top:15px; border-top:1px solid #d17a5a; display:flex; justify-content:space-between;">
                <?php
                // Предыдущий раздел (по menu_order)
                $prev = get_adjacent_post( false, '', true, 'letopis_section' );
                $next = get_adjacent_post( false, '', false, 'letopis_section' );
                if ( $prev ) {
                    echo '<a href="' . esc_url( get_permalink( $prev ) ) . '" style="color:#4a1d1d;">← ' . esc_html( $prev->post_title ) . '</a>';
                } else {
                    echo '<span></span>';
                }
                if ( $next ) {
                    echo '<a href="' . esc_url( get_permalink( $next ) ) . '" style="color:#4a1d1d;">' . esc_html( $next->post_title ) . ' →</a>';
                }
                ?>
            </nav>

        <?php endwhile; endif; ?>
    </div><!-- /.content-box -->

    <?php get_template_part( 'template-parts/aside-posters' ); ?>

</div><!-- /.main-wrapper -->

<?php get_footer(); ?>
