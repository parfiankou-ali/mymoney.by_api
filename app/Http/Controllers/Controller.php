<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function getSuccessfulJsonResponse()
    {
        return response()->json(new \stdClass());
    }
}
