<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    protected $fillable = ["title", "location", "registration_number"];

    public function resources() {
        return $this->hasMany(Resource::class);
    }

    public function storages() {
        return $this->belongsToMany(Storage::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot("sale_price", "amount");
    }
}
