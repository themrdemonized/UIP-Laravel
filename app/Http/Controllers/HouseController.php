<?php

namespace App\Http\Controllers;

use App\Document;
use App\House;
use App\Http\Requests\HouseRequest;
use App\Objectt;
use App\PhotoReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class HouseController extends Controller
{
    private $house;

    public function __construct(House $house)
    {
        $this->house = $house;
    }

    public function getHouses()
    {
        $houses = $this->house->with('object')->get();
        return response()->json([
            'houses' => $houses
        ], 200);
    }

    public function show($id)
    {
        $house = $this->house->with('floorss')->with('object')->findOrFail($id);
        $floors = $house->floorss->map(function ($floor){
            $floor->empty_flats = $floor->flatss()->where('status_id', 1)->count();
            $floor->empty_offices = $floor->offices()->where('status_id', 1)->count();
            $floor->empty_pantries = $floor->pantries()->where('status_id', 1)->count();
            return $floor;
        });

        $docs  = $this->house->docs($id);
        $reports = $this->house->reports($id);
        //$objectName = $this->house->objectName($house->object_id);
        $banks = $house->banks()->get();

        return response()->json([
            'house' => $house,
            'floors' => $floors,
            'docs' => $docs,
            'reports' => $reports,
            'banks' => $banks,
//            'objectName' => $objectName,
        ], 200);
    }

    public function edit($id)
    {
        $house = $this->house->with('floorss')->findOrFail($id);

        return response()->json([
            'house' => $house,
            'objects' => Objectt::get(),
        ], 200);
    }

    public function update(HouseRequest $request, $id)
    {
        $this->house->findOrFail($id)->update($request->all());

        return response()->json([
                'msg' => "Данные дома были обновлены."
            ], 200);
    }

    public function create(HouseRequest $request)
    {
        $this->house->create($request->all());

        return response()->json([
            'msg' => "Дом был успешно добавлен."
        ], 200);
    }

    public function delete($id)
    {
        $house = $this->house->findOrFail($id);
        $objectId = $house->object_id;
        $house->delete();

        return response()->json([
            'houses' => House::where('object_id', $objectId)->get(),
            'msg' => "Дом был успешно удален!"
        ], 200);
    }
}
