<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartisipantRequest;
use App\Http\Services\Identifier\Identifier;
use App\Http\Services\SmsSender\SmsSender;
use App\Lot;
use App\Participant;
use App\Traits\SendMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    use SendMessage;

    private $participant;

    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    public function create(PartisipantRequest $request)
    {
        $this->participant->create($request->all());

        $this->check($request->number);

//        return response()->json([
//            'msg' => "Участник был успешно создан!"
//        ], 200);
    }

    public function check(PartisipantRequest $request)
    {
        $participant = $this->participant->where("number", $request->number)->first();

        $lastParticipant = DB::table('lot_participant')->first();

//        if ($participant->id == $lastParticipant->participant_id) {
//            return response()->json([
//                "msg" => "Вы сделали последнюю ставку"
//            ], 403);
//        }

        if (empty($participant)) {
            $participant = $this->participant->create([
                "fio" => $request->name,
                "number" => $request->number,
                "email" => $request->email,
            ]);

            if ($this->makeIdentifier($participant)) {
                return response()->json([
                    "formShow" => 2,
                    "msg" => "Введите идентификатор из СМС сообщения."
                ], 200);
            }

        } else {

            if ($participant->identifier !== null) {
                return response()->json([
                    "formShow" => 3, // форма с проверкой идентификатора
                    "msg" => "Участнник верефицирован!"
                ], 200);
            }
        }

    }

    public function rates(Request $request)
    {
        $participant = $this->participant->where("number", $request->number)->first();

        if ($participant->identifier == $request->identifier) {
            $rates = DB::table('lot_participant')
                ->join('lots', 'lots.id', '=', 'lot_participant.lot_id')
                ->where('participant_id', $participant->id)
                ->select('lot_participant.*', "lots.name as name")
                ->get();

            return response()->json([
                'rates' => $rates
            ], 200);

        } else {
            return response()->json([
                'msg' => "Неверный идентификатор",
                'errors' => [
                    'identifier' => "Введен неверный идентификатор!"
                ],
            ], 403);
        }

    }

    public function checkIdentifier(Request $request)
    {
        $priceId = [
            1 => 50000,
            2 => 100000,
            3 => 150000,
        ];

        $lot = Lot::findOrfail($request->lotId);

        $lotPrice = $lot->current_price;

//        if ($lot->current_price != "") {
//            $lotPrice = $lot->current_price;
//        } else {
//            $lotPrice = $lot->price;
//        }

        $lastPrice = doubleval($lotPrice) + doubleval($priceId[$request->price]);

        $participant = $this->participant->where("number", $request->number)->first();

        if ($participant->identifier === $request->identifier) {

            $participant->lots()->attach($request->lotId, [
                'price' => doubleval($priceId[$request->price]),
                'date' => date("Y-m-d H:i:s"),
            ]);

            if ($participant->is_verified == "" || $participant->is_verified == null) {
                $participant->update([
                    "is_verified" => 1
                ]);
            }

            $currentDate = date("Y-m-d");

            if ($lot->start <= $currentDate && $lot->end >= $currentDate) {
                $lot->update([
                    "current_price" => $lastPrice,
                ]);
            } else {
                return response()->json([
                    'msg' => 'Лот не активен'
                ], 403);
            }
            //какая то логика

            $lot = Lot::findOrFail($request->lotId);

            $objectId = $lot->flat->floorr->house->object->id;
            $ratePrice = $priceId[$request->price];

            $this->sendMessage(
                "Новая ставка",
                "<p> <b>$participant->fio</b> сделал ставку в $ratePrice</p> <p>Лот: $lot->name</p> <p>Номер для связи: <a href='tel:$request->number'>$request->number</a></p>",
                $objectId
            );

            return response()->json([
                "msg" => "Ставка прошла успешно!",
            ], 200);

        } else {
            return response()->json([
                "msg" => "Введен неверный идентификатор!",
                'errors' => [
                    'identifier' => "Введен неверный идентификатор!"
                ],
            ], 403);
        }
    }

    public function makeIdentifier($participant)
    {
        $identifier = new Identifier(6);
        $genIdentifier = $identifier->generate();

        $participant->update([
            "identifier" => $genIdentifier,
        ]);

        if (SmsSender::send($participant->number, $genIdentifier)) {
            return true;
        } else {
            return response()->json([
                "msg" => "Не удалось отпарвить идентификатор",
            ], 403);
        }

    }

    public function destroy($id)
    {
        $participant = $this->participant->findOrFail($id);
        $participant->delete();

        return response()->json([
            'participants' => $this->participant->get(),
            'msg' => "Лот был успешно удален!"
        ], 200);
    }
}
