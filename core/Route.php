<?php 
namespace Core;

use \WP_REST_Request;
use \WP_REST_Response;


/**
 * Класс для Регистрация маршрутов
*/
class Route{

    

    public static function get(string $root,string $uri,$action,array $array_func, array $args = [])
    {
        self::register( $root,$uri,'GET',$action,$array_func, $args);
    }

    public static function post(string $root,string $uri,$action,array $array_func, array $args = [])
    {
        self::register( $root,$uri,'POST',$action,$array_func, $args);
    }

    public static function put(string $root,string $uri,$action,array $array_func, array $args = [])
    {
        self::register( $root,$uri,'PUT',$action,$array_func, $args);
    }

    public static function delete(string $root,string $uri,$action,array $array_func, array $args = [])
    {
        self::register( $root,$uri,'DELETE',$action,$array_func, $args);
    }

    protected static function register(string $root,string $uri,string $method,$action,$array_func, array $args)
    {
        add_action( 'rest_api_init', function() use ($array_func, $root, $uri,$method,$action,$args){
            register_rest_route( $root, $uri, [
                'methods'=> $method,
                'callback' => $action,
                // 'permission_callback' => [self::class, 'security'],
                'permission_callback' => function(WP_REST_Request $requests) use ($array_func){
                    $result = True;

                    foreach($array_func as $func){
                        $result = $func($requests);

                        if (true !== $result) {
                            return $result;
                        }
                    }

                    return $result;
                },
                'args' => $args
            ] );
        });
    }




}