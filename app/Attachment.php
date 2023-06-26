<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Upload;

class Attachment extends Model
{
    use Upload;

    protected $fillable = ['name', 'path'];
    

}
