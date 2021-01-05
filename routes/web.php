<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/* @var \Laravel\Lumen\Routing\Router $router */
$router->get('/', function () use ($router) {
    return response()->json(new \stdClass());
});

$router->get('/images/users/{userId}/{fileName}', function ($userId, $fileName) {
    $filePath = storage_path("app/images/users/${userId}/${fileName}");
    $file = new \Illuminate\Http\File($filePath);

    $image = \Intervention\Image\Facades\Image::make($file);
    $response = new \Symfony\Component\HttpFoundation\BinaryFileResponse($file, 200, [
        'Content-Type' => $image->mime()
    ]);

    return $response;
});
