<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User', 'trainings_users')->withTimestamps();
    }
}
