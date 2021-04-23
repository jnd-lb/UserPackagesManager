<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{

    public function bundles(){
        return $this->hasMany('App\Bundle');
    }

}
