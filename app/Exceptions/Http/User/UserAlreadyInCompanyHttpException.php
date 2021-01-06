<?php

namespace App\Exceptions\Http\User;

use App\Exceptions\Http\HttpException;

class UserAlreadyInCompanyHttpException extends HttpException
{
    /**
     * Get exception status code.
     *
     * @return int
     */
    public static function getStatusCode(): int
    {
        return 100025;
    }
}
