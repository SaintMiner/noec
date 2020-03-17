<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StorageFullInfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $products = $this->products();
        $busySpace = $products->sum("palete_amount");
        return [
            "id" => $this->id,
            "title" => $this->title,
            "class" => $this->class,
            "location" => $this->location,
            "palete_capacity" => $this->palete_capacity,
            "busySpace" => $busySpace,
            "freeSpace" => $this->palete_capacity - $busySpace,
        ];
    }
}
