<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    public function package()
    {
        return $this->belongsTo('App\Plan');
    }
}
}
