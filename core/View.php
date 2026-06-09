<?php

namespace Core;

/**
 * class View
 * 
 * Класс который реализует механизм регистрация страниц и его контент + механизмы огранчение страницц 
 */
class View
{

    /**
     * Регистрация страниц в вордпрессе
     * 
     * @param string $filePath  Адрес плагина
     * @param string $name // Название страницы
     * @param string $title 
     * @param string $content // Контент страницы
     */
    public static function reg_page(
        string $filePath,
        string $name,
        string $title,
        string $content
    ) {

        // Регистрация страницы
        register_activation_hook($filePath, function () use ($title, $name, $content) {
            if (!get_page_by_path($name)) {
                wp_insert_post([
                    'post_title' => $title,
                    'post_name' => $name,
                    'post_type' => 'page',
                    'post_status' => 'publish',
                    'post_content' => $content,
                ]);
            }
        });
    }

    /**
     * Регистрация шорт кода
     * 
     * @param string $name
     * @param callable $content
     */
    public static function reg_shortcode(string $name, callable $content)
    {
        add_shortcode($name, $content);
    }

    /**
     * Регистрация ограничение на страницы
     * 
     * @param string $page
     * @param array<callable> $array
     */
    public static function reg_redirect(string $page, array $array)
    {
        add_action('template_redirect', function () use ($page, $array) {
            $allow = true;

            foreach ($array as $func) {
                $allow = $allow && $func();
            }

            if (is_page($page) && $allow) {
                wp_redirect(wp_login_url());
                exit;
            }
        });
    }

    /**
     * Регистрация ограничение на страницы
     * 
     * @param array<string>|string $page Страница или список страница 
     * @param array<callable> $array Список функций фильтраций
     * @param callable $call Функция вызова при не пропуске
     */
    public static function reg_redirect_callable(string|array $page, array $array, callable $call)
    {
        if (is_string($page)) {
            $page = [$page];
        }

        foreach ($page as $p) {
            add_action('template_redirect', function () use ($page, $array, $call) {

                $allow = true;

                foreach ($array as $func) {
                    $allow = $allow && $func();
                }

                // текущий путь
                $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

                // разбиваем на сегменты
                $segments = explode('/', trim($request_uri, '/'));

                // первый сегмент
                $first_segment = $segments[0] ?? null;

                foreach ($page as $p) {
                    if ($first_segment === $p && !$allow) {
                        $call();
                        exit;
                    }
                }
            });
        }
    }


    /**
     * Рендерит HTML / PHP файл с данными и возвращает строку
     *
     * @param string $filePath Путь к файлу
     * @param array  $data     Данные для шаблона
     *
     * @return string
     * @throws Exception
     */
    public static function render_template(string $filePath, array $data = []): string
    {
        if (!file_exists($filePath)) {
            throw new Exception("Template not found: {$filePath}");
        }

        // Делаем переменные доступными в шаблоне
        extract($data, EXTR_SKIP);

        // Буферизация вывода
        ob_start();
        include $filePath;
        return ob_get_clean();
    }

    /**
     * Экранизация значений для вставки
     */
    public static function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Закрепленние стиля
     * 
     * @param string $filePath Адрес плагина
     * @param string $name Название стиля
     * @param string $page Название страницы
     * @param string $filePath Путь к файлу стиля относительно от корневой папки плагина пример: assests/js/index.js
     */
    public static function set_page_style(string $filePath, string $name, string $page, string $stylePath)
    {
        add_action('wp_enqueue_scripts', function () use ($filePath, $name, $page, $stylePath) {
            if (!is_page($page))
                return;

            wp_enqueue_style($name . '-style', plugin_dir_url($filePath) . $stylePath, [], filemtime(plugin_dir_path($filePath) . $stylePath));
        });
    }

    /**
     * Закрепленние скриптов
     * 
     * @param string $filePath Адрес плагина
     * @param string $name Название скрипта
     * @param string $page Название страницы
     * @param string $filePath Путь к файлу скрипта относительно от корневой папки плагина пример: assests/js/index.js
     * @param bool $in_footer Куда в подвал?
     */
    public static function set_page_script(string $filePath, string $name, string $page, string $scriptPath, bool $in_footer = true)
    {
        add_action('wp_enqueue_scripts', function () use ($page, $name, $filePath, $scriptPath, $in_footer) {
            if (!is_page($page))
                return;

            wp_enqueue_script($name . '-script', plugin_dir_url($filePath) . $scriptPath, [], filemtime(plugin_dir_path($filePath) . $scriptPath), $in_footer);
        });
    }

    public static function set_script(string $filePath, string $name, string $scriptPath, bool $in_footer = true)
    {
        wp_enqueue_script($name . '-script', plugin_dir_url($filePath) . $scriptPath, [], filemtime(plugin_dir_path($filePath) . $scriptPath), $in_footer);
    }

    /**
     * Закрпленние данных 
     * 
     * @param string $page Название страниц
     * @param string $name Название приложения
     * @param string $app Название набора данных
     * @param callable $func Замыкание которые вернет данные в виде $key=>$value
     */
    public static function set_page_data(string $page, string $name, string $app, callable $func)
    {
        if (!is_page($page))
            return;

        wp_localize_script($name . '-app', $app . '_DATA', $func);
    }

    /**
     * Закрепление шапки на конкретной странице через the_content
     *
     * @param string|null $page  
     * @param string $headerHtml 
     */
    public static function set_header(?string $page, string $headerHtml): void
    {
        add_filter('the_content', function ($originalContent) use ($page, $headerHtml) {

            // не трогаем админку
            if (is_admin()) {
                return $originalContent;
            }

            // только основной цикл
            if (!in_the_loop() || !is_main_query()) {
                return $originalContent;
            }

            // защита от дублей
            static $done = false;
            if ($done) {
                return $originalContent;
            }

            if ($page === null || is_page($page)) {
                $done = true;
                return $headerHtml . $originalContent;
            }

            return $originalContent;
        }, 1);
    }
}
