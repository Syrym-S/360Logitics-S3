<?php
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Capsule\Manager as Capsule;

if (!class_exists(Capsule::class)) {
    require_once __DIR__ . '/vendor/autoload.php';
}

global $wpdb;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => DB_HOST,
    'database'  => DB_NAME,
    'username'  => DB_USER,
    'password'  => DB_PASSWORD,
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => $wpdb->prefix, // поддержка wp-префикса
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$app = new Container();
$app['db'] = $capsule->getDatabaseManager();
Facade::setFacadeApplication($app);

?>