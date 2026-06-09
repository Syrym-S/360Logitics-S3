<?php 

// Прикрепляет новые интервалы расписаний к WP-Cron 
add_filter('cron_schedules', function($schedules){
    $prefix = 'prodavay_';

    $schedules[$prefix . 'every_minute'] = [
        'interval' => 60,
        'display'  => __('Every Minute', 'prodavay-core')
    ];

    $schedules[$prefix . 'every_five_minutes'] = [
        'interval' => 5 * 60,
        'display'  => __('Every Five Minutes', 'prodavay-core')
    ];

    $schedules[$prefix . 'every_ten_minutes'] = [
        'interval' => 10 * 60,
        'display'  => __('Every Ten Minutes', 'prodavay-core')
    ];

    $schedules[$prefix .'every_fifteen_minutes'] = [
        'interval' => 15 * 60,
        'display'  => __('Every Fifteen Minutes', 'prodavay-core')
    ];

    $schedules[$prefix . 'every_twenty_minutes'] = [
        'interval' => 20 * 60,
        'display'  => __('Every Twenty Minutes', 'prodavay-core')
    ];

    $schedules[$prefix . 'every_thirty_minutes'] = [
        'interval' => 30 * 60,
        'display'  => __('Every Thirty Minutes', 'prodavay-core')
    ];

    $schedules[$prefix . 'every_hour'] = [
        'interval' => 60 * 60,
        'display'  => __('Every Hour', 'prodavay-core')
    ];

    $schedules[$prefix . 'every_two_hours'] = [
        'interval' => 2 * 60 * 60,
        'display'  => __('Every Two Hours', 'prodavay-core')
    ];

    $schedules[$prefix . 'every_six_hours'] = [
        'interval' => 6 * 60 * 60,
        'display'  => __('Every Six Hours', 'prodavay-core')
    ];

    $schedules[$prefix . 'every_twelve_hours'] = [
        'interval' => 12 * 60 * 60,
        'display'  => __('Every Twelve Hours', 'prodavay-core')
    ];

    $schedules[$prefix . 'every_day'] = [
        'interval' => 24 * 60 * 60,
        'display'  => __('Every Day', 'prodavay-core')
    ];

    $schedules[$prefix . 'every_week'] = [
        'interval' => 7 * 24 * 60 * 60,
        'display'  => __('Every Week', 'prodavay-core')
    ];

    $schedules[$prefix . 'every_month'] = [
        'interval' => 30 * 24 * 60 * 60,
        'display'  => __('Every Month', 'prodavay-core')
    ];

    $schedules[$prefix . 'every_year'] = [
        'interval' => 365 * 24 * 60 * 60,
        'display'  => __('Every Year', 'prodavay-core')
    ];

    return $schedules;
});

?>