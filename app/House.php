<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class House extends Model
{
    protected $guarded = [];

    public function floorss(){
        return $this->hasMany('App\Floor');
    }

    public function flat(){
        return $this->hasManyThrough('App\Flat', 'App\Floor');
    }

//    public function docs(){
//        return $this->hasMany('App\Document', 'house_id', 'id');
//    }

    public function photoReport(){
        return $this->hasMany('App\PhotoReport');
    }

    public function object(){
        return $this->belongsTo('App\Objectt');
    }

    public function docs($id){
        return DB::table('documents')
            ->join('users', 'users.id', '=', 'documents.user_id')
            ->join('attachments', 'attachments.id', '=', 'documents.file_id')
            ->select('documents.*', 'users.name as user_name', 'attachments.path as path')
            ->where('documents.house_id', $id)
            ->get();
    }

    public function reports($id){
        return PhotoReport::with('photo')->where('house_id', $id)->get();
    }

    public function objectName($id){
        return Objectt::where('id', $id)->pluck('name');
    }

    public function banks(){
        return $this->belongsToMany('App\Bank');
    }
}
