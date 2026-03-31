        </div><!-- /.main-wrapper -->

        <!-- Кнопка полноэкранного режима -->
        <button id="fullscreen-btn" class="fullscreen-toggle" title="На весь экран">
            <svg id="fs-icon" viewBox="0 0 24 24" width="24" height="24" fill="white">
                <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
            </svg>
        </button>

        <footer class="site-footer">
            <div class="footer-inner">
                <div class="footer-col">
                    <span class="f-label">Контакты:</span>
                    <?php echo esc_html( get_option( 'b19_address', 'г. Улан-Удэ, ул. Комсомольская, 23' ) ); ?> &nbsp;|&nbsp;
                    Заведующий: <?php echo esc_html( get_option( 'b19_director', 'Куценко А.Е.' ) ); ?> &nbsp;|&nbsp;
                    <?php echo esc_html( get_option( 'b19_phone', '(3012) 27-07-29' ) ); ?> &nbsp;|&nbsp;
                    <a href="mailto:<?php echo esc_attr( get_option( 'b19_email', '' ) ); ?>">
                        <?php echo esc_html( get_option( 'b19_email', '' ) ); ?>
                    </a>
                </div>
                <div class="footer-col">
                    <span class="f-label">Летнее (1.06–31.08):</span>
                    ПН–ПТ 9:00–18:00, вых. сб/вс &nbsp;|&nbsp;
                    <span class="f-label">Зимнее (01.09–31.05):</span>
                    ВТ–ПТ 10:00–19:00, СБ/ВС 10:00–18:00, вых. пн &nbsp;|&nbsp;
                    Санитарный день — последняя пятница
                </div>
            </div>
            <div class="footer-bottom">
                © <?php echo date( 'Y' ); ?>
                <?php bloginfo( 'name' ); ?>
            </div>
        </footer>

<?php wp_footer(); ?>
</body>
</html>
