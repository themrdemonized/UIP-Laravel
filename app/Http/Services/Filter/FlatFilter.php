<?php

namespace App\Http\Services\Filter;

class FlatFilter extends Filter
{

    public function price($value)
    {
        if($value == 'desc'){
            $this->builder->orderBy('coast', 'desc');
        } else if($value == 'asc'){
            $this->builder->orderBy('coast', 'asc');
        }
    }

    public function room($value)
    {
        if($value == 'desc'){
            $this->builder->orderBy('rooms', 'desc');
        } else if($value == 'asc'){
            $this->builder->orderBy('rooms', 'asc');
        }
    }

    public function area($value)
    {
        if($value == 'desc'){
            $this->builder->orderBy('area', 'desc');
        }else if($value == 'asc'){
            $this->builder->orderBy('area', 'asc');
        }
    }

//    public function object($value)
//    {
//        if($value == 'desc'){
////            $this->builder->has('floorr.house.object')->orderBy('name.objectts', 'desc');
//            $this->builder->whereHas('floorr.house.object', function ($query) use ($value){
//                $query->orderBy('name', $value);
//            });
//        }
//        else if($value == 'asc'){
////            $this->builder->has('floorr.house.object')->orderBy('name', 'asc');
//
//            $this->builder->whereHas('floorr.house.object', function ($query) use ($value){
//                $query->orderBy('name', 'asc');
//            });
//        }
//    }
//
//    public function status($value)
//    {
//        if($value == 'desc'){
//
//            $this->builder->whereHas('floorr.house', function ($query) use ($value){
//                $query->orderBy('status_id', 'desc');
//            });
//
////            $this->builder->orderBy('status_house', 'desc');
//        }else if($value == 'asc'){
//
//
//            $this->builder->whereHas('floorr.house', function ($query) use ($value){
//                $query->orderBy('status_id', 'asc');
//            });
//
////            $this->builder->orderBy('status_house', 'asc');
//        }
//    }
//
//    public function floor($value)
//    {
//        if($value == 'desc'){
//            $this->builder->whereHas('floorr', function ($query) use ($value){
//                $query->orderBy('name', 'desc');
//            });
//        }
//        if($value == 'asc'){
//            $this->builder->whereHas('floorr', function ($query) use ($value){
//                $query->orderBy('name.floorr', 'asc');
//            });
//        }
//    }

    public function rangePrice($value)
    {
        $this->builder->whereBetween('coast', [$value[0], $value[1]]);
    }

    public function rangeArea($value)
    {
        $this->builder->whereBetween('area', [$value[0], $value[1]]);
    }

//    public function rangeFloor($value)
//    {
//        $this->builder->whereBetween('floors.name', [$value[0], $value[1]]);
//    }

    public function roomFilter($value)
    {
        $this->builder->whereIn('rooms', $value);
    }

    public function objectFilter($value)
    {
        $this->builder->whereHas('floorr.house.object', function ($query) use ($value){
            $query->whereIn('id', $value);
        });
    }

//if($request->has('houseFilter')){
//    $flats->where('houses.id', $request->houseFilter);
//}
//
//if($request->has('floorFilter')){
//    $flats->where('floors.id', $request->floorFilter);
//}


}
