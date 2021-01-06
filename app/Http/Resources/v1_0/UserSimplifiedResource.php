<?php

namespace App\Http\Resources\v1_0;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSimplifiedResource extends JsonResource
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
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'company' => new CompanyResource($this->company),
            'image' => new ImageResource($this->image),
        ];
    }
}
