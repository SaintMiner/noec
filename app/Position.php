<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    protected $fillable = ["name"];

    public function resources() {
        return $this->hasMany(Resource::class);
    }

    public function enterprises() {
        return $this->belongsToMany(Enterprise::class);
    }
}
