<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Neww extends Model
{
    protected $guarded = [];

    public function photo(){
        return $this->belongsTo('App\Attachment', 'file_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
