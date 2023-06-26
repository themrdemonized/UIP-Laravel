<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $guarded = [];

    public function flatss(){
        return $this->hasMany('App\Flat');
    }

    public function offices(){
        return $this->hasMany('App\Office');
    }

    public function pantries(){
        return $this->hasMany('App\Pantry');
    }

    public function house(){
        return $this->belongsTo('App\House');
    }

}
