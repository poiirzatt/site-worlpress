<aside class="left-sidebar">

    <!-- Навигационное меню -->
    <div class="menu-container">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_class'     => '',
            'container'      => false,
            'fallback_cb'    => 'biblioteka19_fallback_menu',
        ) );
        ?>
    </div>

    <!-- Поиск по разделам летописи -->
    <div class="search-block">
        <form onsubmit="return false;" role="search">
            <input type="text"
                   id="search-input"
                   placeholder="Поиск по сайту..."
                   aria-label="Поиск"
                   autocomplete="off">
            <button type="button" onclick="runSearch()" aria-label="Найти">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="white">
                    <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5
                             6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79
                             l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5
                             S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
            </button>
        </form>
        <div id="search-results" class="search-results-list"></div>
    </div>

    <!-- Социальные сети -->
    <?php echo do_shortcode( '[social_links]' ); ?>

</aside>
<?php

/**
 * Запасное меню: выводит разделы типа «letopis_section»
 * если в Меню ничего не назначено.
 */
function biblioteka19_fallback_menu() {
    $sections = get_posts( array(
        'post_type'      => 'letopis_section',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ) );

    if ( empty( $sections ) ) {
        echo '<p style="color:#fff;padding:10px;">Разделы не добавлены</p>';
        return;
    }

    echo '<ul>';
    foreach ( $sections as $section ) {
        echo '<li><a href="' . esc_url( get_permalink( $section->ID ) ) . '">'
             . esc_html( $section->post_title )
             . '</a></li>';
    }
    echo '</ul>';
}
