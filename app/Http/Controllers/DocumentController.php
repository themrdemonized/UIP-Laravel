<?php

namespace App\Http\Controllers;

use App\Document;
use App\House;
use App\Http\Requests\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Attachment;
use App\Http\Requests\StoreAttachmentRequest;
use Auth;

class DocumentController extends Controller
{
    private $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function index()
    {
        $docs = $this->document;

//        if (\Auth::user()->role === 3){
            $docs = $docs->with(['house.object', 'user'])->get();
//        } else {
//            $docs = $docs->with(['house.object', 'user'])->where('user_id', Auth::user()->id)->get();
//        }

        return response()->json([
            'docs' => $docs
        ], 200);
    }

    public function show($id)
    {
        $doc = $this->document->with('attachment')->findOrFail($id);

        return response()->json([
            'doc' => $doc
        ], 200);
    }

    public function update(DocumentRequest $request, $id)
    {
        $doc = $this->document->with('attachment')->findOrFail($id);

        if ($request->has('attachment')){
            $attachment = $doc->attachment;
            Storage::disk('my_files')->delete($attachment->path);

            $attachment->update([
                'path' => $attachment->upload($request->attachment, 'my_files', 'uploads/documents'),
            ]);
        }

        $doc->update([
            'name' => $request->name,
            'house_id' => $request->house_id,
        ]);

        return response()->json([
            'msg' => 'Данные документа были успешно обновлены!'
        ], 200);
    }


    public function create(DocumentRequest $request)
    {
        $attachment = new Attachment;
        $attachment->path = $attachment->upload($request->attachment, 'my_files', 'uploads/documents');
        $attachment->save();

        $this->document::create([
            'name' => $request->name,
            'file_id' => $attachment->id,
            'house_id' => $request->house_id,
            'date' => date("y.m.d"),
            'user_id' => \Auth::user()->id,
        ]);

        return response()->json([
            'msg' => 'Докумкент был успешно добавлен!'
        ], 201);
    }

    public function destroy($id)
    {
        $doc = $this->document->with('attachment')->findOrFail($id);
        $attachment = $doc->attachment;
        Storage::disk('my_files')->delete($attachment->path);
        $attachment->delete();
        $doc->delete();

        return response()->json([
            'docs' => Document::get(),
            'msg' => 'Выбранный документ был удален!'
        ], 200);
    }
}
