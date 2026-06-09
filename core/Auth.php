<?php

namespace Core;

class Auth
{
    public static function check_nonce(string $valuename, string $noncename): callable
    {
        return function ($request) use ($valuename, $noncename): bool {
            return (!isset($_POST[$valuename]) || !wp_verify_nonce($_POST[$valuename], $noncename));
        };
    }

    public static function check_roles(array|string $roles): callable
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }

        return function ($request) use ($roles): bool {
            if (!is_user_logged_in()) {
                return false;
            }

            $user = wp_get_current_user();

            // Проверка пересечения ролей
            return !empty(array_intersect($roles, (array) $user->roles));
        };
    }

    public static function check_auth() :callable
    {
        return function($request){
            return is_user_logged_in();
        };
    }
}
