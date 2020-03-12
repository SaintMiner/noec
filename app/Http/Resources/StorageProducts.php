<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StorageProducts extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $pivot = $this->pivot;
        return [
            "id" => $this->id,
            "name" => $this->name,
            "price" => $this->price,
            "amount_per_palete" => $this->amount_per_palete,
            "palete_amount" => $pivot->palete_amount,
        ];
    }
}
