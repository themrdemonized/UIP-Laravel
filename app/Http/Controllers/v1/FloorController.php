<?php

namespace App\Http\Controllers;

use App\Floor;
use App\House;
use App\Objectt;
use App\Office;
use Illuminate\Http\Request;
use Validator;

class FloorController extends Controller
{
    private $floor;

    public function __construct(Floor $floor)
    {
        $this->floor = $floor;
    }

    public function getFloor()
    {
        $flr = Floor::findOrFail(request()->floorId);
        $flrPorch = $flr->porch;
        $floor = Floor::with('flatss')->find(request()->floorId);
        $floors = Floor::where('house_id', $floor->house_id)->where('porch', $flrPorch)->get();
        $house = House::find($floor->house_id);
        $object = Objectt::find($house->object_id);
        $offices = Floor::with('offices')->find(request()->floorId);
        $pantries = Floor::with('pantries')->find(request()->floorId);

        return response()->json([
            'houseName' => $house->name,
            'objectName' => $object->name,
            'type' => $object->type,
            'floor' => $floor,
            'floors' => $floors,
            'offices' => $offices->offices,
            'pantries' => $pantries->pantries,
        ], 200);
    }

    public function edit($id)
    {
        $floor = $this->floor->findOrFail($id);
        $house = House::find($floor->house_id);
        $object = Objectt::find($house->object_id);

        $objects = Objectt::all();
        $houses = House::where('object_id', $object->id)->get();

        return response()->json([
            'objects' => $objects,
            'object' => $object,
            'houses' => $houses,
            'house' => $house,
            'floor' => $floor,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $v = Validator::make($request->all(), [
            'floorName' => 'required',
            'floorFlats' => 'required',
            'floorEmpty' => 'required',
            'floorImage' => 'required',
            'floorViewBox' => 'required',
            'floorCoordinates' => 'required',
            'house' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'errors' => $v->errors()
            ], 422);
        }

        $floor = $this->floor->findOrFail($id);

        $floor->update([
            'name' => $request->floorName,
            'flats' => $request->floorFlats,
            'flats_empty' => $request->floorEmpty,
            'img' => $request->floorImage,
            'viewBox' => $request->floorViewBox,
            'coordinates' => $request->floorCoordinates,
            'house_id' => $request->house,
        ]);

        return response()->json([
            'msg' => "Данные этажа были обновлены."
        ], 200);

    }

    public function create(Request $request)
    {
        $v = Validator::make($request->all(), [
            'floorName' => 'required',
            'floorFlats' => 'required',
            'floorEmpty' => 'required',
            'floorImage' => 'required',
            'floorViewBox' => 'required',
            'floorCoordinates' => 'required',
            'house' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'errors' => $v->errors()
            ], 422);
        }

        Floor::create([
            'name' => $request->floorName,
            'flats' => $request->floorFlats,
            'flats_empty' => $request->floorEmpty,
            'img' => $request->floorImage,
            'viewBox' => $request->floorViewBox,
            'coordinates' => $request->floorCoordinates,
            'house_id' => $request->house,
        ]);

        return response()->json([
            'msg' => "Этаж был успешно добавлен."
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        $floor = $this->floor->findOrFail($id);
        $houseId = $floor->house_id;
        $floor->delete();

        return response()->json([
            'floors' => Floor::where('house_id', $houseId)->get(),
            'msg' => "Этаж был успешно удален!"
        ], 200);
    }
}
