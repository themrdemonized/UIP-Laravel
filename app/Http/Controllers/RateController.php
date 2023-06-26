<?php

namespace App\Http\Controllers;

use App\Lot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RateController extends Controller
{
    public function destroy($id)
    {
        $rate = DB::table("lot_participant")->where("id", $id)->first();

        $lot = Lot::findOrFail($rate->lot_id);

        $newPrice = doubleval($lot->current_price) - doubleval($rate->price);

        if (doubleval($newPrice) <= doubleval($lot->price)) {
            $newPrice = $lot->price;
        }

        $lot->update([
            'current_price' => $newPrice
        ]);

        DB::table("lot_participant")->where("id", $id)->delete();

        return response()->json([
            'msg' => "Ставка была удалена"
        ],200);
    }
}
