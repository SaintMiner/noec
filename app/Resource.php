<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = "resources";

    protected $fillable = ["name", "surname", "enterprise_id", "position_id", "status_id", "department_id", "job_candidated"];

    public function department() {
        return $this->belongsTo(Department::class);
        // public function user()
        // {
        //     return $this->belongsTo('App\User', 'foreign_key', 'other_key');
        // }
    }

    public function enterprise() {
        return $this->belongsTo(Enterprise::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function position() {
        return $this->belongsTo(Position::class);
    }


}
