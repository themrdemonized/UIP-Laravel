<?php


namespace App\Http\Services\Filter;

use Illuminate\Http\Request;

abstract class Filter
{
    protected $builder;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach($this->filters() as $filter => $value){
            if(method_exists($this, $filter)){
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function filters()
    {
        return $this->request->all();
    }
}
