<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoReport extends Model
{
    protected $guarded = [];

    public function house()
    {
        return $this->belongsTo('App\House');
    }

    public function photo()
    {
        return $this->belongsToMany('App\Attachment', 'attachments_photo_reports', 'report_id', 'attachment_id');
    }
}
