<?php

namespace App\Exceptions\Http\Image;

use App\Exceptions\Http\HttpException;

class ImageFileNotFoundHttpException extends HttpException
{
    /**
     * Get exception status code.
     *
     * @return int
     */
    public static function getStatusCode(): int
    {
        return 200005;
    }
}
