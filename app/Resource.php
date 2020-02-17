<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    
    public function department() {
        return $this->belongsTo(Department::class);
        // public function user()
        // {
        //     return $this->belongsTo('App\User', 'foreign_key', 'other_key');
        // }
    }

}
