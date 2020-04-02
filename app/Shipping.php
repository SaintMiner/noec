<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = ["enterprise_id", "storage_id", "type", "status"];

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot("product_count");
    }
}
