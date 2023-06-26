<?php

namespace App\Http\Controllers;

use App\Call;
use App\Http\Requests\CallRequest;
use App\Traits\SendMessage;
use App\User;
use Illuminate\Http\Request;
use Mail;
use Validator;

class CallController extends Controller
{
    use SendMessage;

    private $call;

    public function __construct(Call $call)
    {
        $this->call = $call;
    }

    public function create(CallRequest $request)
    {
        $this->call->create([
            'name' => $request->name,
            'number' => $request->number
        ]);

        $this->sendMessage(
            "Обратный звонок",
            "<p> <b>$request->name</b> оставил заявку на обратный звонок</p> <p>Номер для связи: <a href='tel:$request->number'>$request->number</a></p>"
        );

        return response()->json([
            'msg' => "Заявка была успешно создана. Ожидайте звонка."
        ], 200);
    }

    public function index()
    {
        request()->has('statusId') ? $calls = $this->call->where('status', request()->statusId)->orderBy('id', 'desc')->get() : $calls = $this->call->get();

        return response()->json([
            'calls' => $calls
        ], 200);
    }

    public function update($id, $status = null)
    {
        $call = $this->call->findOrFail($id);

        if(request()->statusId == "false"){
            $status = 1;
        }

        if(request()->statusId == "true"){
            $status = 2;
        }

        $call->update([
            'status' => $status
        ]);

        return response()->json([
            'calls' => $this->call->get(),
            'msg' => 'Статус обратного звонка был успешно изменен!'
        ], 200);
    }

    public function destroy($id)
    {
        $call = $this->call->findOrFail($id);

        if($call->status == 1){
            return response()->json([
                'msg' => "Невозможно удалить, т.к. сатус данного звонка - 'Новый' "
            ], 422);
        }else{
            $call->delete();
        }

        return response()->json([
            'calls' => $this->call->get(),
            'msg' => "Звонок был успешно удален!"
        ], 200);
    }
}
