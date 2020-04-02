<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = ["enterprise_id", "storage_id", "type", "status"];

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot("pallete_count");
    }

    public function storage() {
        return $this->belongsTo(Storage::class);
    }

    public function enterprise() {
        return $this->belongsTo(Enterprise::class);
    }
}
