<?php

namespace App\Exceptions\Http;

class InvalidCredentialsHttpException extends HttpException
{
    /**
     * Get exception status code.
     *
     * @return int
     */
    public static function getStatusCode(): int
    {
        return 100001;
    }
}
