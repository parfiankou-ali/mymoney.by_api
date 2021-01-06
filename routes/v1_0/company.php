<?php

/**
 * @var App\Routes\Route $route
 * @var Laravel\Lumen\Routing\Router $router
 */

$router->group(['middleware' => 'auth:api',], function () use ($route) {
    $route->post('company.create');
    $route->post('company.update');
    $route->post('company.delete');
    $route->get('company.get');

});
