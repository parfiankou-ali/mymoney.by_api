<?php

/**
 * The routes to manage a certificate.
 *
 * @var App\Routes\Route $route
 * @var Laravel\Lumen\Routing\Router $router
 */

// $route->post('user.signIn');
// $route->post('user.signUp');

$router->group(['middleware' => 'auth:api',], function () use ($route) {
    // $route->post('user.update');
    // $route->get('user.get');
});
