<?php

namespace App\Http\Controllers;

use App\Flat;
use App\Floor;
use App\House;
use App\Http\Requests\ReserveRequest;
use App\Objectt;
use App\Office;
use App\OfficeReserve;
use App\Pantry;
use App\PantryReserve;
use App\Reserve;
use App\Traits\SendMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;
use Validator;
use Mail;

class ReserveController extends Controller
{
    use SendMessage;

    private $reserve;

    public function __construct(Reserve $reserve)
    {
        $this->reserve = $reserve;
    }

    public function index()
    {
        $reserves = $this->reserve;

        !request()->has('statusId') ? $reserves = $reserves : $reserves = $reserves->where('status', request()->statusId);

        if(request()->has('showItem')){
            if (\request()->showItem === 'flat'){
                $reserves = $reserves->where('reservable_type', 'квартира');
            }
            if (\request()->showItem === 'office'){
                $reserves = $reserves->where('reservable_type', 'офис');
            }
            if (\request()->showItem === 'pantry'){
                $reserves = $reserves->where('reservable_type', 'кладовка');
            }
        }

        $reserves = $reserves->with('reservable.floorr.house.object')->get();

        return response()->json([
            'reserves' => $reserves
        ],200);
    }

    public function destroy($id)
    {
       $reserve = $this->reserve->findOrFail($id);

        if($reserve->status == 0){
            return response()->json([
                'msg' => "Невозможно удалить, т.к. сатус данной брони - 'Новый' "
            ], 422);
        }else{
            $reserve->delete();
        }

        return response()->json([
           'msg' => 'Бронь была успешно удалена.'
        ], 200);
    }

    public function show($id)
    {
        $reserve = $this->reserve->with('reservable.floorr.house.object')->findOrFail($id);

        return response()->json([
            'reserve' => $reserve,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $reserve = $this->reserve->findOrFail($id);
        $status = $this->statusChecked($request->status);

        $reserve->update([
            'status' => $status
        ]);

        return response()->json([
            'msg' => 'Бронь была успешно изменена.',
        ], 200);
    }

    public function statusChecked($status)
    {
        if($status == "false"){
            return false;
        }else if($status == "true"){
            return true;
        }
        return null;
    }

    public function getReserveObject($type, $id)
    {
        if($type === 'квартира'){
            
            // Flat::findOrFail($id)->update([
            //     "status_id" => 3
            // ]);
            
            return Flat::findOrFail($id);
        }
        if($type === 'офис'){
            // Office::findOrFail($id)->update([
            //     "status_id" => 3
            // ]);

            return Office::findOrFail($id);
        }
        if($type === 'кладовка'){
            // Pantry::findOrFail($id)->update([
            //     "status_id" => 3
            // ]);

            return Pantry::findOrFail($id);
        }

        return null;
    }

    
    public function create(ReserveRequest $request)
    {
        $reserveObject = $this->getReserveObject($request->type, $request->id);

        $reserveObject->reserves()->create([
            'name' => $request->name,
            'number' => $request->number,
            'reservable_id' => $reserveObject->id,
        ]);

        $object = $reserveObject->floorr->house->object->name;
        $objectId = $reserveObject->floorr->house->object->id;
        $house = $reserveObject->floorr->house->name;

        $this->sendMessage(
            "Бронь",
            "<p> <b>{$request->name}</b> оставил заявку на бронирование:</p> <p>Объект: {$object}</p> <p>Дом: {$house}</p> <p>Тип: {$request->type}</p> <p>Номер: {$reserveObject->name}</p> <p>Номер для связи: <a href='tel:{$request->number}'>{$request->number}</a></p>",
            $objectId
        );

        return response()->json([
            'msg' => 'Заявка на бронирование успешно создана. Ожидайте звонка.',
        ], 200);
    }
}
