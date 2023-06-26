<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObjecttRequest;
use App\Objectt;

class ObjectController extends Controller
{
    private $object;

    public function __construct(Objectt $object)
    {
        $this->object = $object;
    }

    public function getObjectsForNav()
    {
        $fields = [
            'id',
            'name'
        ];

        $objects = $this->object->select($fields)->whereHas('houses')->toBase()->get();

        if (empty($objects)){
            abort(404);
        }

        return response()->json([
            'objects' => $objects,
        ],200);
    }

    public function getObjects()
    {
        $objects = $this->object->with('houses.floorss.flatss')->orderBy('id', 'desc')->get();

        $emptyFlats = 0;
        $minPrice = 0;

        foreach ($objects->whereIn('id', [1, 2, 10, 18, 21]) as $object){
            $object->whereHas('houses.floorss.flatss', function () use ($object, $emptyFlats, $minPrice){
                foreach ($object->houses as $house){
                    foreach ($house->floorss as $floor){
                        $flats = $floor->flatss->where('status_id', 1);
                        $emptyFlats += $flats->count();
                        $minPrice = $flats->min('coast');
                    }

                }
                $object->emptyFlats = $emptyFlats;
                $object->minPrice = $minPrice;
            });
        }

        return response()->json([
            'objects' => $objects,
        ], 200);
    }

    public function show($id)
    {
//        $object = $this->object->with('houses')->findOrFail($id);
        $object = $this->object->with('houses.floorss.flatss')->findOrFail($id);

        $empty = [];
        foreach ($object->houses as $house){
            $emptyFlats= 0;
            foreach ($house->floorss as $floor){
                $flats = $floor->flatss->where('status_id', 1);
                $emptyFlats += $flats->count();
            }
            $house->emptyFlats = $emptyFlats;
        }

        $objectName = $object->name;

        return response()->json([
            'object' => $object,
            'objectName' => $objectName,
        ], 200);
    }

    public function update(ObjecttRequest $request, $id)
    {
        $this->object->findOrFail($id)->update($request->all());

        return response()->json([
            'msg' => "Данные объекта были обновлены."
        ], 200);
    }

    public function create(ObjecttRequest $request)
    {
        $this->object->create($request->all());

        return response()->json([
            'msg' => "Объект был успешно добавлен."
        ], 200);
    }

    public function delete($id)
    {
        $this->object->findOrFail($id)->delete();

        return response()->json([
            'objects' => $this->object->get(),
            'msg' => "Объект был успешно удален."
        ], 200);
    }

}
