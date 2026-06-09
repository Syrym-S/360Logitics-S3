<?php 
/**
 * Plugin Name: 360Logistics S3
 * Description: Плагин для реализация работы с S3 хранилищем и локальными хранилищями.
 * Author:      Suleimenov Syrym / 360Solutions
 * Text Domain: logistics_s3
 * Domain Path: /languages
 * Requires at least: 6.9
 * Requires PHP: 8.3
 * GitHub Plugin URI: Syrym-S/360Logistics-S3
 * GitHub Branch: main
 * Version: 1.0.0
 */

if ( ! (defined( 'ABSPATH')
        && defined('ROLLBACK')
        && defined('IS_PROD')))  {
            error_log("Плагин не активирован\n ");
    exit; // Проверка на вордпресс
} 


/**
 * Технические глобальные переменные которые не надо настроивать 
 * И это должна быть в начале index.php
*/
define('LOGISTICS_PLUGIN_FILE', __FILE__);
define('LOGISTICS_URL', plugin_dir_url(LOGISTICS_PLUGIN_FILE));
define('LOGISTICS_PATH', plugin_dir_path(LOGISTICS_PLUGIN_FILE));

/**
 * Подключение Composer и autoload 
*/
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Загрзука bootstrap 
 * require_once __DIR__ . '/bootstrap';
*/
require_once __DIR__ . '/bootstrap/eloquent-bootstrapper.php'; // Загрузка Eloquent ORM

/**
 * Загрузка крон событий и расписаний
 * require_once __DIR__ . '/cron';
*/
require_once __DIR__ . '/cron/schedules.php';
require_once __DIR__ . '/cron/cron.php';

/**
 * ==========================================================
 *                          ХУКИ
 * ==========================================================
 * require_once __DIR__ . '/app/hooks';
*/
require_once __DIR__ . '/app/Hooks/admin.php';
require_once __DIR__ . '/app/Hooks/activation.php'; // Хуки активизации и деактивизации плагина
require_once __DIR__ . '/app/Hooks/route.php'; // Маршруты
require_once __DIR__ . '/app/Hooks/scripts.php'; // Хуки очереди загрузки js скриптов
require_once __DIR__ . '/app/Hooks/view.php'; // Хуки представление
require_once __DIR__ . '/app/Hooks/cron.php';