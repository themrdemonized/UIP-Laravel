<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $guarded = [];

    public function houses(){
        return $this->belongsToMany('App\House');
    }
}
