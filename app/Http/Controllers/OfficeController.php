<?php

namespace App\Http\Controllers;

use App\Floor;
use App\House;
use App\Http\Requests\OfficeRequest;
use App\Http\Services\Filter\FlatFilter;
use App\Objectt;
use App\Office;
use Illuminate\Http\Request;
use Validator;

class OfficeController extends Controller
{
    private $office;

    public function __construct(Office $office)
    {
        $this->office = $office;
    }

    public function search()
    {
        $offices = $this->office->with('floorr.house.object')->get();

        return response()->json([
            'offices' => $offices,
        ], 200);
    }

    public function index(FlatFilter $filters)
    {
        $offices = $this->office->with('floorr.house.object')->where("status_id", 1)->filter($filters)->get();

        $emptyOffices = $this->office->where('status_id', 1);

        $minPrice =  $emptyOffices->min('coast');
        $maxPrice =  $emptyOffices->max('coast');
        $minArea =  $emptyOffices->min('area');
        $maxArea =  $emptyOffices->max('area');

        $objects = Objectt::has('houses.floorss.offices')->get();

        return response()->json([
            'offices' => $offices,
            'objects' => $objects,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'minArea' => $minArea,
            'maxArea' => $maxArea,
        ], 200);
    }

    public function show($id)
    {
        $office = $this->office->with('floorr.house.object')->findOrFail($id);

        $offices = $this->office->where('floor_id', $office->floor_id)->toBase()->get();

        $newOffices = [];

        foreach ($offices as $of){
            if ($of->id !== $office->id){
                array_push($newOffices,$of);
            }
        }

        return response()->json([
            'office' => $office,
            'offices' => $newOffices,
        ], 200);
    }

    public function edit($id)
    {
        $office = $this->office->with('floorr.house.object')->findOrFail($id);

        $objects = Objectt::get();
        $houses = House::where('object_id', $office->floorr->house->object->id)->get();
        $floors = Floor::where('house_id', $office->floorr->house->id)->get();

        return response()->json([
            'objects' => $objects,
            'houses' => $houses,
            'floors' => $floors,
            'office' => $office
        ], 200);
    }

    public function update(OfficeRequest $request, $id)
    {
        $this->office->findOrFail($id)->update($request->all());

        return response()->json([
            'msg' => "Данные офиса были обновлены."
        ], 200);
    }

    public function create(OfficeRequest $request)
    {
        $this->office->create($request->all());

        return response()->json([
            'msg' => "Офис был успешно создан"
        ], 200);
    }

    public function delete($id)
    {
       $this->office->findOrFail($id)->delete();

       return response()->json([
           'offices' => $this->office->get(),
           'msg' => "Офис был успешно удален!"
       ], 200);


    }
}
