<?php

namespace App\Http\Controllers;

use App\Office;
use App\Reserve;
use App\Flat;
use Illuminate\Http\Request;

class SpaController extends Controller
{
    public function index()
    {
//        $office = Flat::first();
//
////        $office = $office->reserves;
//
//        $office->reserves()->create([
//            'name' => rand(1,10),
//            'number' => rand(1,10),
//        ]);
//
//        return response()->json([
//            'query' => $office
//        ], 200);

        return view('welcome');
    }
}
