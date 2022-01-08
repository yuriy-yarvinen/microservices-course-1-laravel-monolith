<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
        $UserResource = [
            'id'=> $this->id,
            'first_name'=> $this->first_name,
            'last_name'=> $this->last_name,
            'email'=> $this->email,
        ];

        return $UserResource;
    }
}
