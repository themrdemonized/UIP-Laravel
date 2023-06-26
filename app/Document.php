<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = [];

    public function attachment(){
        return $this->belongsTo('App\Attachment', 'file_id', 'id');
    }

    public function house()
    {
        return $this->belongsTo('App\House');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

}
