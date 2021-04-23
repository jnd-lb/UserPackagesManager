<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestLogging extends Model
{
    public $timestamps = ["created_at"];
    const UPDATED_AT = null;
    protected $table="requests_logging";
    protected $fillable = ["method","withToken","details"];
}
