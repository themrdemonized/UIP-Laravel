<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Flat;
use App\Http\Requests\LotRequest;
use App\Lot;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class LotController extends Controller
{
    private $lot;

    public function __construct(Lot $lot)
    {
        $this->lot = $lot;
    }

    public function index()
    {
        $currentDate = date("Y-m-d");

        $lots = $this->lot->with(["photo", "flat.floorr.house.object"])
            ->where("status_id", 1)
            ->get();


        $lots = $lots->map(function ($lot) use ($currentDate) {
            if ($lot->start <= $currentDate && $lot->end >= $currentDate) {
                $lot->active = 1;
            } else if ($currentDate < $lot->start) {
                $lot->active = 2;
            } else if ($currentDate > $lot->end){
                $lot->active = 3;
            }
            return $lot;
        });

        return response()->json([
            "lots" => $lots
        ], 200);
    }

    public function adminIndex()
    {
        $lots = $this->lot->get();

        return response()->json([
            "lots" => $lots,
        ], 200);
    }

    public function edit($id)
    {
        $lot = $this->lot->with('photo')->findOrFail($id);
        $rates = $lot->participant;

        return response()->json([
            "lot" => $lot,
            'rates' => $rates,
            'flats' => Flat::get()
        ], 200);
    }

    public function create(LotRequest $request)
    {
        $attachment = new Attachment;
        $attachment->path = $attachment->upload($request->attachment, 'my_files', 'uploads/lots');
        $attachment->save();

        $dateStart = date("Y-m-d", strtotime($request->start));
        $dateEnd= date("Y-m-d", strtotime($request->end));

        $flat = Flat::findOrFail($request->flat_id);

        $flat->update([
            'status_id' => 4
        ]);

        $this->lot->create([
            "name" => $request->name,
            "flat_id" => $request->flat_id,
            "img" => $attachment->id,
            "price" => $request->price,
            "start" => $dateStart,
            "end" => $dateEnd,
            "address" => $request->address,
            "status_id" => $request->status_id,
            "side" => $request->side,
            "current_price" => $request->price,
        ]);

        return response()->json([
            'msg' => "Лот был успешно создан!"
        ], 200);
    }

    public function update(LotRequest $request)
    {
        $lot = $this->lot->with('photo')->findOrFail($request->id);

        if ($request->has('attachment')) {
            $attachment = $lot->photo;
            Storage::disk('my_files')->delete($attachment->path);

            $attachment->update([
                'path' => $attachment->upload($request->attachment, 'my_files', 'uploads/news'),
            ]);
        }

        if (count($lot->has('participant')->get()) > 0) {
            return response()->json([
                'msg' => "Вы не можете изменить действующий аукцион"
            ], 403);
        }

        $dateStart = date("Y-m-d", strtotime($request->start));
        $dateEnd= date("Y-m-d", strtotime($request->end));

        $lot->update([
            "name" => $request->name,
            "flat_id" => $request->flat_id,
            "price" => $request->price,
            "start" => $dateStart,
            "end" => $dateEnd,
            "address" => $request->address,
            "status_id" => $request->status_id,
            "side" => $request->side,
            "current_price" => $request->price
        ]);

        return response()->json([
            'msg' => "Данные лота были успешно обновлены!"
        ], 200);
    }

    public function destroy($id)
    {
        $this->lot->findOrFail($id)->delete();

        return response()->json([
            'lots' => $this->lot->get(),
            'msg' => "Лот был успешно удален!"
        ], 200);
    }
}
