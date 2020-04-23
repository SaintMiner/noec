<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Positions extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "employee_count" => $this->resources->count(),
        ];
    }
}
