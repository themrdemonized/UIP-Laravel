<?php

namespace App\Http\Controllers;

use App\Flat;
use App\Floor;
use App\House;
use App\Http\Requests\FlatRequest;
use App\Http\Services\Filter\FlatFilter;
use App\Objectt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class FlatController extends Controller
{
    private $flat;

    public function __construct(Flat $flat)
    {
        $this->flat = $flat;
    }

    public function show($id)
    {
        $flat = $this->flat->with('floorr.house.object')->findOrFail($id);

        return response([
            'flat' => $flat,
        ], 200);
    }

    public function index(FlatFilter $filters)
    {
        $flats = $this->flat->with('floorr.house.object')->where('status_id', 1)->filter($filters)->get();

        $flat = $this->flat->where('status_id', 1);

        $minPrice = $flat->min('coast');
        $maxPrice =$flat->max('coast');
        $minArea = $flat->min('area');
        $maxArea = $flat->max('area');
//        $minFloor= Floor::min('name');
//        $maxFloor = Floor::max('name');

        return response([
            'flats' => $flats,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'minArea' => $minArea,
            'maxArea' => $maxArea,
//            'minFloor' => $minFloor,
//            'maxFloor' => $maxFloor,
        ], 200);
    }

    public function adminIndex()
    {
        $flats = $this->flat->where('floor_id', request()->floorId)->get();
        $floors = Floor::get();

        return response()->json([
           'flats' => $flats,
           'floors' => $floors,
        ], 200);
    }

    public function edit($id)
    {
        $flat = $this->flat->with('floorr.house.object')->findOrFail($id);

        $objects = Objectt::all();
        $houses = House::where('object_id', $flat->floorr->house->object->id)->get();
        $floors = Floor::where('house_id', $flat->floorr->house->id)->get();

        return response()->json([
            'flat' => $flat,
            'objects' => $objects,
            'houses' => $houses,
            'floors' => $floors,
        ], 200);
    }

    public function update(FlatRequest $request, $id)
    {
        $this->flat->findOrFail($id)->update($request->all());

        return response()->json([
            'msg' => 'Данные квартиры были успешно обновлены!'
        ], 200);
    }

    public function create(FlatRequest $request)
    {
        $this->flat->create($request->all());

        return response()->json([
            'msg' => 'Квартира была успешно создана!'
        ], 200);
    }

    public function delete($id)
    {
        $flat = $this->flat->findOrFail($id);
        $floorId = $flat->floor_id;
        $flat->delete();

        return response()->json([
            'flats' => $this->flat->where('floor_id', $floorId)->get(),
            'msg' => "Квартира была успешно удалена!"
        ], 200);
    }
}
