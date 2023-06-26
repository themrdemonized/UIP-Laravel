<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objectt extends Model
{
    protected $guarded = [];

    public function houses(){
        return $this->hasMany('App\House', 'object_id', 'id');
    }

    public function images()
    {
        return $this->hasMany('App\ObjectImages', 'object_id', 'id');
    }
//    public function getEmptyZalupsAttribute(){
//        return $this->houses()->sum('empty_flats');
//    }
}
