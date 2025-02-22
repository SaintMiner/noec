<?php

namespace App\Http\Resources;

use App\Resource;
use Illuminate\Http\Resources\Json\JsonResource;
class User extends JsonResource
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
            "id" => $this->id,
            "username" => $this->username,
            "roles" => $this->roles,
            "resource_id" => $this->resource_id,
        ];
    }
}
