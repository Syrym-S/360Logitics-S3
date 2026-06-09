<?php

use App\Controllers\FileController;
use Core\Route;

add_action('plugins_loaded', function () {
    /**
     * получение файла по уникальный пути
     */
    Route::get(
        '/storage',
        '/v1/get/(?P<id>[a-f0-9]{24})',
        [new FileController(), 'getFile'],
        [],
        [
            'id' => [
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field',
                'validate_callback' => fn($v) => (bool) preg_match('/^[a-f0-9]{24}$/', $v),
            ],
        ]
    );

    /**
     * получение информации о файле по уникальный пути
    */
    Route::get(
        '/storage',
        '/v1/info/(?P<id>[a-f0-9]{24})',
        [new FileController(), 'getFileInfo'],
        [],
        [
            'id' => [
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field',
                'validate_callback' => fn($v) => (bool) preg_match('/^[a-f0-9]{24}$/', $v),
            ],
        ]
    );
});
