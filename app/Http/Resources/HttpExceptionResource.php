<?php

namespace App\Http\Resources;

use App\Http\Enums\HttpExceptionCode;
use Illuminate\Http\Resources\Json\JsonResource;

class HttpExceptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'response' => $this->response ?: new \stdClass(),
            'status_code' => $this->status_code ?: HttpExceptionCode::INTERNAL_SERVER_ERROR,
        ];
    }
}
