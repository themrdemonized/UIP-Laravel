<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pantry extends Model
{
    protected $guarded = [];

    public function floorr(){
        return $this->belongsTo('App\Floor', 'floor_id', 'id');
    }

    public function reserves(){
        return $this->morphMany('App\Reserve', 'reservable');
    }
}
