<?php

namespace App\Routes;

use Laravel\Lumen\Routing\Router;

abstract class RoutesCollector
{
    public static function Collect(string $path, Router $router): void
    {
        foreach (glob("${path}/**/*.php") as $filename)
        {
            $shortPath = str_replace('\\', '/', substr(
                $filename,
                strlen($path) + 1,
                -strlen('.php')));
            list($version) = explode('/', $shortPath);

            $route = new Route($router);
            $router->group(['namespace' => $version, 'prefix' => $version], function () use ($route, $router, $filename) {
                /** @noinspection PhpIncludeInspection */
                require_once $filename;
            });
        }
    }
}
