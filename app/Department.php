<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = "departments";

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ["name"];

    public function resources() {
        return $this->hasMany(Resource::class);
    }

    public function enterprises() {
        return $this->belongsToMany(Enterprise::class)->withPivot("manager");
    }
}
