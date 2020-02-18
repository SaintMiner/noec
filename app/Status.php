<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function resources() {
        return $this->hasMany(Resource::class);
    }
}
