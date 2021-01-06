<?php

/**
 * @var App\Routes\Route $route
 * @var Laravel\Lumen\Routing\Router $router
 */

$router->group(['middleware' => 'auth:api',], function () use ($route) {
    $route->get('image.get');
});
