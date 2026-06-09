<?php

namespace Core;

// Создание папок во время активизация плагина и работы самоого скрипта
class DirMaker
{
    /**
     * Функция создает папку в указаном пути
     * 
     * @param string $path // путь где мы будем создавать 
     * @param string $dir_name // название папки который мы будем создавать 
     * 
     * @return bool
    */
    public static function make(string $path, string $dir_name): bool
    {
        $path = rtrim($path, "/\\");
        $dir_name = trim($dir_name, "/\\");

        if ($dir_name === '') {
            return false;
        }

        // 1) Проверяем базовый путь
        if (!self::check_path($path)) {
            return false;
        }

        // 2) Если папка уже существует — ок
        if (self::check_dir($path, $dir_name)) {
            return true;
        }

        // 3) Создаем
        $fullPath = $path . DIRECTORY_SEPARATOR . $dir_name;

        // WordPress way (если есть)
        if (function_exists('wp_mkdir_p')) {
            return wp_mkdir_p($fullPath);
        }

        // Обычный php
        return @mkdir($fullPath, 0755, true);
    }

    /**
     * Функция проверяет на наличия пути и его доступа
     * 
     * @param string $path // Путь который будем проверять 
     * @return bool 
    */
    private static function check_path(string $path): bool
    {
        if ($path === '') {
            return false;
        }

        // Если пути нет — пробуем создать (удобно при активации плагина)
        if (!is_dir($path)) {
            if (function_exists('wp_mkdir_p')) {
                if (!wp_mkdir_p($path)) {
                    return false;
                }
            } else {
                if (!@mkdir($path, 0755, true)) {
                    return false;
                }
            }
        }

        // После создания ещё раз убеждаемся
        if (!is_dir($path)) {
            return false;
        }

        // Проверяем права на запись
        if (!is_writable($path)) {
            return false;
        }

        return true;
    }

    /**
     * функцция проверяет на наличие папки в этом пути 
     * 
     * @param string $path
     * @param string $dir_name
     * 
     * @return bool
    */
    private static function check_dir(string $path, string $dir_name): bool
    {
        $path = rtrim($path, "/\\");
        $dir_name = trim($dir_name, "/\\");

        if ($path === '' || $dir_name === '') {
            return false;
        }

        $fullPath = $path . DIRECTORY_SEPARATOR . $dir_name;

        return is_dir($fullPath);
    }
}
