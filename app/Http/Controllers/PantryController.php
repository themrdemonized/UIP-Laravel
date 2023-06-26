<?php

namespace App\Http\Controllers;

use App\Floor;
use App\House;
use App\Http\Requests\PantryRequest;
use App\Objectt;
use App\Pantry;
use Illuminate\Http\Request;
use Validator;

class PantryController extends Controller
{

    private $pantry;

    public function __construct(Pantry $pantry)
    {
        $this->pantry = $pantry;
    }


    public function index()
    {
        $pantries = $this->pantry->with('floorr.house.object')->get();

        return response()->json([
            'pantries' => $pantries
        ], 200);
    }

    public function edit($id)
    {
        $pantry = $this->pantry->with('floorr.house.object')->findOrFail($id);

        $objects = Objectt::get();
        $houses = House::where('object_id', $pantry->floorr->house->object->id)->get();
        $floors = Floor::where('house_id', $pantry->floorr->house->id)->get();

        return response()->json([
            'objects' => $objects,
            'houses' => $houses,
            'floors' => $floors,
            'pantry' => $pantry
        ], 200);
    }

    public function update(PantryRequest $request, $id)
    {
        $this->pantry->findOrFail($id)->update($request->all());

        return response()->json([
            'msg' => "Данные кладовки были обновлены."
        ], 200);
    }

    public function create(PantryRequest $request)
    {
        $this->pantry->create($request->all());

        return response()->json([
            'msg' => "Офис был успешно создан"
        ], 200);
    }

    public function delete($id)
    {
        $this->pantry->findOrFail($id)->delete();

        return response()->json([
            'pantries' => $this->pantry->get(),
            'msg' => "Кладовка была успешно удалена!"
        ], 200);
    }
}
