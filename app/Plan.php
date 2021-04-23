<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function bundles()
    {
        return $this->hasMany('App\Bundle');
    }
}
