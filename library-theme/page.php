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

        <?php endwhile; endif; ?>
    </div>

    <?php get_template_part( 'template-parts/aside-posters' ); ?>

</div>

<?php get_footer(); ?>
