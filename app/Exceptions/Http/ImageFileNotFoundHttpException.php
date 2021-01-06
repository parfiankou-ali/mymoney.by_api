<?php

namespace App\Exceptions\Http;

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
