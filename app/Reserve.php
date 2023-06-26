<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    protected $guarded = [];

//    public function flat(){
//        return $this->belongsTo('App\Flat');
//    }

    public function reservable(){
        return $this->morphTo();
    }
}
