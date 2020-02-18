<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    public function resources() {
        return $this->hasMany(Resource::class);
    }
}
