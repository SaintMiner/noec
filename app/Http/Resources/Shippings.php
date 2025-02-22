<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Shippings extends JsonResource
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
            "enterprise" => $this->enterprise,
            "storage" => $this->storage,
            "type" => $this->type,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "products" => $this->products,
        ];
    }
}
