<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PantryReserve extends Model
{
    protected $guarded = [];

    public function pantry(){
        return $this->belongsTo('App\Pantry');
    }
}
