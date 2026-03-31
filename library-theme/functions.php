<?php
/**
 * Biblioteka19 — functions.php
 * Подключение стилей, скриптов, поддержка меню и кастомного логотипа.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ─── 1. Базовая поддержка темы ─── */
function biblioteka19_setup() {
    // Переводы
    load_theme_textdomain( 'biblioteka19', get_template_directory() . '/languages' );

    // HTML5
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'gallery', 'caption' ) );

    // Кастомный логотип
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 150,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Заголовок сайта в теге <title>
    add_theme_support( 'title-tag' );

    // Миниатюры записей
    add_theme_support( 'post-thumbnails' );

    // Основная навигация
    register_nav_menus( array(
        'primary' => __( 'Левое боковое меню', 'biblioteka19' ),
    ) );
}
add_action( 'after_setup_theme', 'biblioteka19_setup' );

/* ─── 2. Стили и скрипты ─── */
function biblioteka19_assets() {
    // Основной CSS
    wp_enqueue_style(
        'biblioteka19-main',
        get_template_directory_uri() . '/assets/css/stele.css',
        array(),
        '1.0'
    );

    // Плагин BVI (версия для слабовидящих)
    wp_enqueue_script(
        'bvi-jquery',
        'https://lidrekon.ru/slep/js/jquery.js',
        array(),
        null,
        false
    );
    wp_enqueue_script(
        'bvi-uhpv',
        'https://lidrekon.ru/slep/js/uhpv-full.min.js',
        array( 'bvi-jquery' ),
        null,
        false
    );

    // Основной JS темы
    wp_enqueue_script(
        'biblioteka19-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0',
        true   // в подвале
    );
}
add_action( 'wp_enqueue_scripts', 'biblioteka19_assets' );

/* ─── 3. Регистрация произвольных типов записей ─── */
function biblioteka19_register_post_types() {

    // Тип «Раздел летописи»
    register_post_type( 'letopis_section', array(
        'labels' => array(
            'name'          => 'Разделы летописи',
            'singular_name' => 'Раздел летописи',
            'add_new_item'  => 'Добавить раздел',
            'edit_item'     => 'Редактировать раздел',
        ),
        'public'        => true,
        'has_archive'   => false,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-book-alt',
        'supports'      => array( 'title', 'editor', 'page-attributes' ),
        'rewrite'       => array( 'slug' => 'letopis' ),
        'show_in_rest'  => true,  // поддержка Gutenberg
    ) );

    // Тип «Афиши»
    register_post_type( 'poster', array(
        'labels' => array(
            'name'          => 'Афиши',
            'singular_name' => 'Афиша',
            'add_new_item'  => 'Добавить афишу',
        ),
        'public'       => true,
        'has_archive'  => false,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-format-image',
        'supports'     => array( 'title', 'thumbnail', 'custom-fields' ),
        'rewrite'      => array( 'slug' => 'afishi' ),
        'show_in_rest' => true,
    ) );
}
add_action( 'init', 'biblioteka19_register_post_types' );

/* ─── 4. Таксономия для разделов (порядок в меню) ─── */
function biblioteka19_register_taxonomies() {
    register_taxonomy( 'letopis_cat', 'letopis_section', array(
        'label'        => 'Категории летописи',
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => array( 'slug' => 'letopis-cat' ),
    ) );
}
add_action( 'init', 'biblioteka19_register_taxonomies' );

/* ─── 5. Шорткод [social_links] для блока соцсетей ─── */
function biblioteka19_social_shortcode() {
    // Ссылки настраиваются в Настройки → Sociale / wp-admin или прямо здесь
    $links = array(
        array(
            'url'   => get_option( 'b19_social_cbs', 'https://cbs-uu.ru/' ),
            'label' => 'Главный сайт МАУ ЦБС',
            'icon'  => get_template_directory_uri() . '/assets/images/fav_cbs.png',
        ),
        array(
            'url'   => get_option( 'b19_social_vk', 'https://vk.com/lib19uu' ),
            'label' => 'ВКонтакте',
            'icon'  => get_template_directory_uri() . '/assets/images/fav_vk.png',
        ),
        array(
            'url'   => get_option( 'b19_social_tg', 'https://t.me/maucbs' ),
            'label' => 'Telegram',
            'icon'  => get_template_directory_uri() . '/assets/images/fav_tg1.png',
        ),
    );

    ob_start();
    echo '<div class="social-block">';
    echo '<p class="social-title">Наши социальные сети</p>';
    foreach ( $links as $link ) {
        echo '<a href="' . esc_url( $link['url'] ) . '" class="social-link" target="_blank" rel="noopener">';
        echo '<img src="' . esc_url( $link['icon'] ) . '" width="20" alt="">';
        echo esc_html( $link['label'] );
        echo '</a>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode( 'social_links', 'biblioteka19_social_shortcode' );

/* ─── 6. Настройки социальных сетей в «Настройки» → «Чтение» ─── */
function biblioteka19_settings_init() {
    add_settings_section( 'b19_social_section', 'Социальные сети', null, 'reading' );

    $fields = array(
        'b19_social_cbs' => 'Ссылка: Главный сайт МАУ ЦБС',
        'b19_social_vk'  => 'Ссылка: ВКонтакте',
        'b19_social_tg'  => 'Ссылка: Telegram',
    );
    foreach ( $fields as $id => $label ) {
        register_setting( 'reading', $id, 'esc_url_raw' );
        add_settings_field( $id, $label, function() use ( $id ) {
            echo '<input type="url" name="' . esc_attr( $id ) . '" value="' . esc_attr( get_option( $id, '' ) ) . '" class="regular-text">';
        }, 'reading', 'b19_social_section' );
    }
}
add_action( 'admin_init', 'biblioteka19_settings_init' );

/* ─── 7. AJAX-поиск по разделам летописи ─── */
function biblioteka19_ajax_search() {
    check_ajax_referer( 'b19_search_nonce', 'nonce' );

    $query = sanitize_text_field( wp_unslash( $_GET['q'] ?? '' ) );
    if ( strlen( $query ) < 2 ) {
        wp_send_json_error( 'too_short' );
    }

    $posts = get_posts( array(
        'post_type'      => 'letopis_section',
        'posts_per_page' => 20,
        's'              => $query,
        'post_status'    => 'publish',
    ) );

    $results = array();
    foreach ( $posts as $post ) {
        $results[] = array(
            'id'    => $post->ID,
            'title' => $post->post_title,
            'url'   => get_permalink( $post->ID ),
        );
    }

    wp_send_json_success( $results );
}
add_action( 'wp_ajax_b19_search',        'biblioteka19_ajax_search' );
add_action( 'wp_ajax_nopriv_b19_search', 'biblioteka19_ajax_search' );

/* ─── 8. Передача данных в JS ─── */
function biblioteka19_localize_script() {
    wp_localize_script( 'biblioteka19-main', 'B19', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'b19_search_nonce' ),
        'action'  => 'b19_search',
    ) );
}
add_action( 'wp_enqueue_scripts', 'biblioteka19_localize_script', 20 );

/* ─── 9. Сортировка разделов летописи по menu_order ─── */
function biblioteka19_section_order( $query ) {
    if ( ! is_admin() && $query->is_main_query() && is_singular( 'letopis_section' ) ) {
        $query->set( 'orderby', 'menu_order' );
        $query->set( 'order', 'ASC' );
    }
}
add_action( 'pre_get_posts', 'biblioteka19_section_order' );
