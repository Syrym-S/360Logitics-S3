<?php

namespace Core;

/**
 * class AdminView 
 * 
 * Ядро для представление в админ меню
 * Регистрация саб страниц и страниц
 * 
 * @package Core\AdminView
 */
class AdminView
{
    /**
     * Статик метод для регистрация страницы
     * Аналогично:
     * add_menu_page(
     *          'Моя страница',          // title страницы
     *          'Мой плагин',            // название в меню
     *          'manage_options',        // права доступа
     *          'my-plugin-page',        // slug страницы
     *          'my_plugin_page_html',   // функция вывода
     *          'dashicons-admin-generic', // иконка
     *          25                       // позиция
     *      );
     * 
     * @param string $title title страницы
     * @param string $name_in_admin название в меню
     * @param string|array $root права доступа
     * @param string $slug slug страницы
     * @param callable|string $callback функция вывода
     * @param string $icon иконка
     * @param int $position позиция
     * 
     * @return string
     */
    public static function reg_admin(
        string $title,
        string $name_in_admin,
        string|array $root,
        string $slug,
        callable|string $callback,
        string $icon,
        int $position,
    ) {
        add_action('admin_menu', function () use ($callback, $icon, $name_in_admin, $position, $root, $slug, $title) {
            add_menu_page(
                $title,             // title страницы
                $name_in_admin,     // название в меню
                $root,              // права доступа
                $slug,              // slug страницы
                $callback,          // функция вывода
                $icon,              // иконка
                $position           // позиция
            );
        });

        return $slug;
    }

    /**
     * Статик метод для регистрация страницы
     * Аналогично: 
     * add_submenu_page(
     *  'my-plugin',
     *  'Настройки',
     *  'Настройки',
     *  'manage_options',
     *  'my-plugin-settings',
     *  'my_plugin_settings_page'
     * );
     * 
     *
     * @param string        $parent_slug Parent menu slug.
     * @param string        $page_title  Page title.
     * @param string        $menu_title  Menu title.
     * @param string        $capability  Capability required.
     * @param string        $menu_slug   Menu slug.
     * @param callable|null $callback    Function to output page content.
     * @param int|null      $position    Position in submenu.
     *
     * @return string|false Hook suffix on success, false on failure.
     */
    public static function reg_sub_admin(
        string $parent_slug,
        string $page_title,
        string $menu_title,
        string $capability,
        string $menu_slug,
        callable|string $callback = '',
        ?int $position = null
    ) {
        add_action('admin_menu', function () use ($callback, $capability, $menu_slug, $menu_title, $page_title, $parent_slug, $position) {
            add_submenu_page(
                $parent_slug,
                $page_title,
                $menu_title,
                $capability,
                $menu_slug,
                $callback,
                $position
            );
        });

        return $menu_slug;
    }
}
