<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $fillable = ["title", "location", "class", "palete_capacity"];

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot("palete_amount");
    }
}
