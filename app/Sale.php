<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ["enterprise_id", "discount"];

    public function products() {
        return $this->belongsToMany(Product::class);
    }
}
