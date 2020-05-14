<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Sale extends JsonResource
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
            "enterprise" => $this->enterprise->name,
            "discount" => $this->discount,
            "products" => $this->products,
            "total_cost" => $this->getTotalCost(),
            "created_at" => $this->created_at,
        ];
    }

}
