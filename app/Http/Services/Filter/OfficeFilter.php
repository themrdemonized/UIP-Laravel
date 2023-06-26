<?php


namespace App\Http\Services\Filter;


class OfficeFilter extends Filter
{
    public function price($value)
    {
        if($value == 'desc'){
            $this->builder->orderBy('coast', 'desc');
        } else if($value == 'asc'){
            $this->builder->orderBy('coast', 'asc');
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


}
