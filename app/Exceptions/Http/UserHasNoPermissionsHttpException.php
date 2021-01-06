<?php

namespace App\Exceptions\Http;

class UserHasNoPermissionsHttpException extends HttpException
{
    /**
     * Get exception status code.
     *
     * @return int
     */
    public static function getStatusCode(): int
    {
        return 100010;
    }
}
