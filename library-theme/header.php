<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header" style="display:flex; align-items:center; justify-content:space-between; padding:0 40px; height:80px;">

    <h1 style="margin:0; padding:0;">
        <?php if ( has_custom_logo() ) : ?>
            <?php the_custom_logo(); ?>
        <?php else : ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.png' ); ?>"
                     alt="<?php bloginfo( 'name' ); ?>"
                     style="max-height:60px; width:auto;">
            </a>
        <?php endif; ?>
    </h1>

    <!-- Кнопка «Версия для слабовидящих» (плагин BVI) -->
    <div id="specialButton"
         style="cursor:pointer; display:flex; align-items:center; gap:8px;
                background:#fdf5e6; border:2px solid #d17a5a; border-radius:10px; padding:10px 15px;">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/eye.png' ); ?>"
             alt="Глаз" style="height:28px; display:block;">
        <span style="font-weight:bold; color:#4a1d1d; font-size:14px;">Версия для слабовидящих</span>
    </div>

</header>
