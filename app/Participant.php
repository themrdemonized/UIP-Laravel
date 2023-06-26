<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $guarded = [];

    public function lots()
    {
        return $this->belongsToMany("App\Lot")->withPivot("price", 'date');
    }
}
