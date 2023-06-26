<?php

namespace App\Http\Controllers;

use App\Call;
use App\Flat;
use App\Floor;
use App\House;
use App\Neww;
use App\Objectt;
use App\OfficeReserve;
use App\PantryReserve;
use App\Reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;


class AdminSpaController extends Controller
{

    public function getObjects(){
        $objects = Objectt::get();

        return response()->json([
            'objects' => $objects,
        ], 200);
    }

    public function getHouses(){
        $houses = House::where('object_id', request()->objectId)->get();

        return response()->json([
            'houses' => $houses,
        ], 200);
    }

    public function getFloors(){
        $floors = Floor::where('house_id', request()->selectHouse)->get();

        return response()->json([
            'floors' => $floors,
        ], 200);
    }

    public function getFlats(){
        $flats = Flat::where('floor_id', request()->selectFloor)->get();

        return response()->json([
            'flats' => $flats,
        ], 200);
    }

    public function updHousePrice(){
        $v = Validator::make(\request()->all(), [
            'selectHouse' => 'required',
            'priceForArea' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'errors' => $v->errors()
            ], 422);
        }

        $flats = DB::table('flats')
            ->join('floors', 'flats.floor_id', '=', 'floors.id')
            ->join('houses', 'floors.house_id', '=', 'houses.id')
            ->select('flats.*')
            ->where('houses.id', request()->selectHouse);

        $flats->update([
            'coast_area' => request()->priceForArea,
            'coast' => DB::raw('flats.area * '.request()->priceForArea)
        ]);

        return response()->json([
            'msg' => 'Цена по дому за квадратный метр изменена',
        ], 200);
    }

    public function updFloorsPrice(){
        $v = Validator::make(\request()->all(), [
            'selectFloor' => 'required',
            'priceForArea' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'errors' => $v->errors()
            ], 422);
        }

        $flats = DB::table('flats')
            ->join('floors', 'flats.floor_id', '=', 'floors.id')
            ->select('flats.*')
            ->whereIn('floor_id', request()->selectFloor);


        $flats->update([
            'coast_area' => request()->priceForArea,
            'coast' => DB::raw('flats.area * '.request()->priceForArea)
        ]);

        return response()->json([
            'msg' => 'Цена по этажу за квадратный метр изменена',
        ], 200);
    }

    public function updFlatPrice(){
        $v = Validator::make(request()->all(), [
            'selectFlat' => 'required',
            'priceForArea' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'errors' => $v->errors()
            ], 422);
        }

        $flats = DB::table('flats')
            ->select('flats.*')
            ->whereIn('id', request()->selectFlat);

        $flats->update([
            'coast_area' => request()->priceForArea,
            'coast' => DB::raw('flats.area * '.request()->priceForArea)
        ]);

        return response()->json([
            'msg' => 'Цена по этажу за квадратный метр изменена',
        ], 200);
    }

    public function getDash(){
        $flatsInSold = Flat::where('status_id', 1)->count();
        $calls = Call::where('status', 1)->count();
        $reserves = Reserve::where('status', 0)->count();
        $news = Neww::count();

        return response()->json([
            'flatsInSold' => $flatsInSold,
            'calls' => $calls,
            'reserves' => $reserves,
            'news' => $news,
        ], 200);
    }

    public function findFlats(Request $request)
    {
        $objects = Objectt::get();

        $flats = DB::table('flats')
            ->join('floors', 'flats.floor_id', '=', 'floors.id')
            ->join('houses', 'floors.house_id', '=', 'houses.id')
            ->join('objectts', 'houses.object_id', '=', 'objectts.id')
            ->select('flats.*', 'floors.id as floor_id', 'floors.name as name_floor',
                'houses.id as house_id', 'houses.name as name_house', 'houses.status_id as status_house',
                'objectts.name as name_object', 'objectts.id as object_id');

        if($request->has('selectStatus')){
            $flats->where('flats.status_id', $request->selectStatus);
        }

        if($request->has('selectObject')){
            $flats->where('object_id', $request->selectObject);
        }

        if($request->has('selectHouse')){
            $flats->where('house_id', $request->selectHouse);
        }

        if($request->has('selectFloor')){
            $flats->where('floor_id',  intval($request->selectFloor));
        }

        $flats = $flats->orderBy('status_id', 'asc')->get();

        return response()->json([
            'flats' => $flats,
            'objects' => $objects
        ], 200);
    }

    public function changeFlatStatus(){
        $flat = Flat::find(request()->flatId);

        $floor = Floor::find($flat->floor_id);
        $house = House::find($floor->house_id);
        $object = Objectt::find($house->object_id);

        $flatName = $flat->name;

        $flat->update(['status_id' => request()->selectStatus]);

        $flatsCounter = Flat::where('floor_id',  $floor->id)->where('status_id', 1)->count();
        $floor->update(['flats_empty' => $flatsCounter]);

        $floorsCounter = Floor::where('house_id', $house->id)->sum('flats_empty');
        $house->update(['empty_flats' => $floorsCounter]);

        $houseCounter = House::where('object_id', $object->id)->sum('empty_flats');
        $object->update(['empty_flats' => $houseCounter]);

        return response()->json([
            'msg' => "Статус квартиры №$flatName был успешно обновлен"
        ], 200);
    }

}
