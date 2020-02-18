<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = "departments";

    protected $hidden = ['created_at', 'updated_at'];


    public function resources() {
        return $this->hasMany(Resource::class);
    }
}
