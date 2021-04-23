<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        "id","text","value","alias","price","pending","status","plan_id","package_id"
    ];

    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    public function package()
    {
        return $this->belongsTo('App\Plan');
    }

}
