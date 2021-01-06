<?php

namespace App\Exceptions\Http\Company;

use App\Exceptions\Http\HttpException;

class CompanyNotFoundHttpException extends HttpException
{
    /**
     * Get exception status code.
     *
     * @return int
     */
    public static function getStatusCode(): int
    {
        return 300001;
    }
}
