<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReserveRequest;
use App\Objectt;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Traits\SendMessage;

class FakeReserveController extends Controller
{
    use SendMessage;

    public function getObjectForReserve($id)
    {
        if($id == 1 || $id == 2 || $id == 16){
            return response()->json(['message' => 'Not Found!'], 404);
        }

        $object = Objectt::with('images')->findOrfail($id);

        return response()->json([
            'object' => $object,
        ], 200);
    }

    public function create(ReserveRequest $request)
    {
        $object = Objectt::select(['id', 'name'])->findOrfail($request->id);

        $this->sendMessage(
            "Бронь",
            "<p> <b>$request->name</b> оставил заявку на бронирование:</p> <p>Объект: $object->name</p> <p>Номер (кладовки/парковки): $request->item</p> <p>Номер для связи: <a href='tel:$request->number'>$request->number</a></p>",
            $object->id
        );

        return response()->json([
            'msg' => 'Заявка на бронирование успешно создана. Ожидайте звонка.'
        ], 201);
    }
}
