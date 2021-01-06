<?php

namespace App\Http\Resources\v1_0;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'gender' => $this->gender,
            'birth_date' => Carbon::parse($this->birth_date)->toDateString(),
            'phone_number' => $this->phone_number,
            'company' => new CompanyResource($this->company),
            'role' => $this->role,
            'employee_code' => $this->employee_code,
            'image' => new ImageResource($this->image),
        ];
    }
}
