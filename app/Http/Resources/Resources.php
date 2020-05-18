<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Resources extends JsonResource
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
            "surname" => $this->surname,
            "department" => $this->department ? $this->department->name : "",
            "enterprise" => $this->enterprise ? $this->enterprise->title : "",
            "status" => $this->status ? $this->status : ["name" => "", "color" => ""],
            "position" => $this->position ? $this->position->name : "",
            "user" => new User($this->user),
            "job_candidated" => $this->job_candidated,
        ];
    }
}
