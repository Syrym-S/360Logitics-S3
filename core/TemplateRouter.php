<?php

namespace Core;

class TemplateRouter
{
    /**
     * Инициализация маршрутизации
     */
    public static function register(string $pageSlug): void
    {
        add_action('init', function () use ($pageSlug) {

            // Ловим 
            /**
             * add_rewrite_rule() — это основной инструмент WordPress для кастомной маршрутизации URL
            */
            add_rewrite_rule(
                '^' . preg_quote($pageSlug, '#') . '(/.*)?$',
                'index.php?pagename=' . $pageSlug,
                'top'
            );
        });

        // flush при активации
        /**
         * add_rewrite_rule() — это основной инструмент WordPress для кастомной маршрутизации URL
        */
        register_activation_hook(LOGISTICS_PLUGIN_FILE, function () use ($pageSlug) {
            add_rewrite_rule(
                '^' . preg_quote($pageSlug, '#') . '(/.*)?$',
                'index.php?pagename=' . $pageSlug,
                'top'
            );
            flush_rewrite_rules();
        });

        register_deactivation_hook(LOGISTICS_PLUGIN_FILE, function () {
            flush_rewrite_rules();
        });

        /**
         * Чтобы не было canonical redirect:
         * WP может попытаться “исправить” URL и редиректить на $pageSlug
         * нам это нельзя.
         * 
         * Фильтр redirect_canonical — это один из самых важных хуков WordPress, 
         * который отвечает за “правильный (канонический) URL” и автоматические редиректы.
         */
        add_filter('redirect_canonical', function ($redirect_url) use ($pageSlug) {
            $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

            if ($path === $pageSlug || str_starts_with($path, $pageSlug . '/')) {
                return false;
            }

            return $redirect_url;
        });
    }
}
