<?php

use Mosyle\Routers;

$files = array_merge(
    glob('mosyle' . DIRECTORY_SEPARATOR . '*.php'),
    glob('app' . DIRECTORY_SEPARATOR . 'validator' . DIRECTORY_SEPARATOR . '*.php'),
    glob('app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . '*.php'),
    glob('app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . '*.php'),
    glob('app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . '*.php'),
    glob('app' . DIRECTORY_SEPARATOR . 'middleware' . DIRECTORY_SEPARATOR . '*.php'),
);

foreach ($files as $file) {
    require_once($file);
}

$config = require_once('app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'db.php');
\Mosyle\DB::init($config);

require_once('app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'routes.php');

$REQUEST_URI = rtrim($_SERVER['REDIRECT_URL'], '/');
$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];

$route = Routers::getRoute($REQUEST_URI, $REQUEST_METHOD);
if (isset($route->route)) {
    try {
        $result = $route->route->call($route->params);
        if ($result instanceof \Mosyle\Response) {
            $result->send();
        }
        return;
    } catch (Exception $e) {
        (new \Mosyle\Response('Internal server error', 'internal_server_error', 500))->send();
    }
} else {
    (new \Mosyle\Response('Not Found', 'Route not found', 404))->send();
}
