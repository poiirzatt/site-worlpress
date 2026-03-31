/* ============================================================
   Biblioteka19 — main.js
   Поиск по разделам летописи + полноэкранный режим
   ============================================================ */

(function () {
    'use strict';

    /* ─── ПОИСК ─── */

    var currentSearchQuery = '';

    function clearHighlights() {
        document.querySelectorAll('.content-body mark.highlight').forEach(function (mark) {
            var parent = mark.parentNode;
            parent.replaceChild(document.createTextNode(mark.textContent), mark);
            parent.normalize();
        });
    }

    /**
     * Подсвечивает слово в контейнере.
     * Работает через TreeWalker, чтобы не ломать HTML-теги.
     */
    function applyHighlight(container, query) {
        if (!query) return;
        clearHighlights();

        var walker = document.createTreeWalker(container, NodeFilter.SHOW_TEXT, null, false);
        var nodes = [];
        var node;
        while ((node = walker.nextNode())) {
            nodes.push(node);
        }

        var regex = new RegExp('(' + query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');

        nodes.forEach(function (textNode) {
            if (!regex.test(textNode.nodeValue)) return;
            regex.lastIndex = 0;

            var frag = document.createDocumentFragment();
            var last = 0;
            var match;

            while ((match = regex.exec(textNode.nodeValue)) !== null) {
                frag.appendChild(document.createTextNode(textNode.nodeValue.slice(last, match.index)));
                var mark = document.createElement('mark');
                mark.className = 'highlight';
                mark.textContent = match[0];
                frag.appendChild(mark);
                last = regex.lastIndex;
            }
            frag.appendChild(document.createTextNode(textNode.nodeValue.slice(last)));
            textNode.parentNode.replaceChild(frag, textNode);
        });
    }

    /* AJAX-поиск через WordPress (B19 передаётся через wp_localize_script) */
    function runSearch() {
        var input = document.getElementById('search-input');
        if (!input) return;

        var query = input.value.trim();
        var resultsContainer = document.getElementById('search-results');
        if (!resultsContainer) return;

        resultsContainer.innerHTML = '';

        if (query.length < 2) {
            resultsContainer.style.display = 'none';
            currentSearchQuery = '';
            clearHighlights();
            return;
        }

        currentSearchQuery = query.toLowerCase();

        /* Если на странице раздела — сразу подсвечиваем */
        var contentBody = document.querySelector('.content-body');
        if (contentBody) {
            applyHighlight(contentBody, currentSearchQuery);
        }

        /* AJAX-запрос к WP */
        var url = B19.ajaxUrl
            + '?action=' + encodeURIComponent(B19.action)
            + '&nonce='  + encodeURIComponent(B19.nonce)
            + '&q='      + encodeURIComponent(query);

        fetch(url)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!data.success || !data.data.length) {
                    resultsContainer.style.display = 'block';
                    resultsContainer.innerHTML = '<div style="padding:10px;color:#ffcccc;">Ничего не найдено</div>';
                    return;
                }

                resultsContainer.style.display = 'block';
                data.data.forEach(function (item) {
                    var div = document.createElement('a');
                    div.className    = 'search-result-item';
                    div.href         = item.url;
                    div.textContent  = item.title;
                    resultsContainer.appendChild(div);
                });
            })
            .catch(function () {
                resultsContainer.style.display = 'block';
                resultsContainer.innerHTML = '<div style="padding:10px;color:#ffcccc;">Ошибка поиска</div>';
            });
    }

    /* Экспортируем, чтобы onclick="runSearch()" в sidebar.php работал */
    window.runSearch = runSearch;

    document.addEventListener('DOMContentLoaded', function () {
        var searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') runSearch();
            });
            searchInput.addEventListener('input', function () {
                if (!searchInput.value) {
                    currentSearchQuery = '';
                    clearHighlights();
                    var r = document.getElementById('search-results');
                    if (r) r.style.display = 'none';
                }
            });
        }

        /* ─── ПОЛНОЭКРАННЫЙ РЕЖИМ ─── */
        var fsBtn  = document.getElementById('fullscreen-btn');
        var fsIcon = document.getElementById('fs-icon');

        var pathExpand   = 'M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z';
        var pathCollapse = 'M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z';

        if (fsBtn) {
            fsBtn.addEventListener('click', function () {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen().catch(function () {});
                } else {
                    document.exitFullscreen();
                }
            });
        }

        document.addEventListener('fullscreenchange', function () {
            if (!fsIcon) return;
            var path = document.fullscreenElement ? pathCollapse : pathExpand;
            fsIcon.querySelector('path').setAttribute('d', path);
        });

        /* ─── Подсветка при открытии страницы, если есть ?s= ─── */
        var urlParams = new URLSearchParams(window.location.search);
        var s = urlParams.get('s');
        if (s && s.length >= 2) {
            var cb = document.querySelector('.content-body');
            if (cb) applyHighlight(cb, s.toLowerCase());
        }
    });

}());
