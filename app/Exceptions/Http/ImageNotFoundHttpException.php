<?php

namespace App\Exceptions\Http;

class ImageNotFoundHttpException extends HttpException
{
    /**
     * Get exception status code.
     *
     * @return int
     */
    public static function getStatusCode(): int
    {
        return 200001;
    }
}
