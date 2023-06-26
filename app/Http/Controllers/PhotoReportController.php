<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Http\Requests\PhotoReportsRequest;
use App\PhotoReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class PhotoReportController extends Controller
{

    private $photoReport;

    public function __construct(PhotoReport $photoReport)
    {
        $this->photoReport = $photoReport;
    }

    public function index()
    {
        $photoReports = $this->photoReport->with('house.object')->get();

        return response()->json([
            'photoReports' => $photoReports
        ], 200);
    }

    public function edit($id)
    {
         $photoReport = $this->photoReport->with('photo')->findOrFail($id);

         return response()->json([
             'photoReport' => $photoReport
         ], 200);
    }

    public function create(PhotoReportsRequest $request)
    {
        $photoReport = $this->photoReport->create([
            'title' => $request->name,
            'house_id' => $request->house_id
        ]);

        if (!empty($request->images) ) {
          foreach ($request->images as $image){
              $attachment = new Attachment;
              $attachment->path = $attachment->upload($image, 'my_files', 'uploads/photoReports');
              $attachment->save();
              $photoReport->photo()->save($attachment);
          }
        }
        return response()->json([
            'msg' => 'Фотоотчет был успешно создан'
        ], 200);
    }

    public function update(PhotoReportsRequest $request, $id)
    {
            $photoReport = $this->photoReport->findOrFail($id);

            if($request->has('images')){
                foreach ($request->images as $image){
                    $attachment = new Attachment;
                    $attachment->path = $attachment->upload($image, 'my_files', 'uploads/photoReports');
                    $attachment->save();
                    $photoReport->photo()->save($attachment);
                }
            }

            $photoReport->update([
                'title' => $request->name,
                'house_id' => $request->house_id,
            ]);

            return response()->json([
                'msg' => 'Фотоотчет был успешно изменен.'
            ], 200);
    }

    public function delete($id)
    {
        $photoReport = $this->photoReport->findOrFail($id);
        $attachments = $photoReport->photo;
        $photoReport->photo()->detach();

        foreach ($attachments as $item) {
            Storage::disk('my_files')->delete($item->path);
            $item->delete();
        }

        $photoReport->delete();

        return response()->json([
            'msg' => 'Фотоотчет был успешно удален.',
            'photoReports' => $this->photoReport->with('house.object')->get(),
        ], 200);
    }
}
