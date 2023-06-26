<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Lot extends Model
{
    protected $guarded = [];

    public function flat()
    {
        return $this->belongsTo("App\Flat");
    }

    public function photo()
    {
        return $this->belongsTo('App\Attachment', 'img', 'id');
    }

    public function participant()
    {
        return $this->belongsToMany("App\Participant")->withPivot("price", 'date', 'id');
    }
}
