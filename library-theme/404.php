<?php get_header(); ?>

<div class="main-wrapper">

    <?php get_sidebar(); ?>

    <div class="content-box">
        <div class="content-header">
            <h2 class="content-title">Страница не найдена</h2>
            <div class="header-line"></div>
        </div>
        <div class="content-body">
            <p>Запрашиваемая страница не существует. Воспользуйтесь меню слева или вернитесь
               <a href="<?php echo esc_url( home_url( '/' ) ); ?>">на главную</a>.</p>
        </div>
    </div>

    <?php get_template_part( 'template-parts/aside-posters' ); ?>

</div>

<?php get_footer(); ?>
