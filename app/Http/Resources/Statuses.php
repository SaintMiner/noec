<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Statuses extends JsonResource
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
            "name" => $this->name,
            "color" => $this->color,
            "people_count" => $this->resources->count(),
        ];
    }
}
