<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public $timestamps = false;

    protected $fillable = ["id","environment","name"."type","alias","shortDescriptionEn","price"];
    
    public function bundles(){
        return $this->hasMany('App\Bundle');
    }

}
