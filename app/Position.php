<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function resources() {
        return $this->hasMany(Resource::class);
    }
}
