<?php

namespace App\Exceptions\Http\Company;

use App\Exceptions\Http\HttpException;

class CompanyHasEmployeesHttpException extends HttpException
{
    /**
     * Get exception status code.
     *
     * @return int
     */
    public static function getStatusCode(): int
    {
        return 300005;
    }
}
