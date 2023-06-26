<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfficeReserve extends Model
{
    protected $guarded = [];

    public function office(){
        return $this->belongsTo('App\Office');
    }
}
