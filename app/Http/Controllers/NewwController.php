<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Http\Requests\NewRequest;
use App\Neww;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class NewwController extends Controller
{
    protected $new;

    public function __construct(Neww $new){
        $this->new = $new;
    }

    public function adminIndex()
    {
        $news = $this->new->with('user')->orderBy('id', 'desc')->get();

        return response()->json([
            'news' => $news
        ], 200);
    }

    public function index()
    {
        $news = $this->new->with('photo')->orderBy('id', 'desc')->get();

        return response()->json([
            'news' => $news
        ], 200);
    }

    public function show($id)
    {
        $new = $this->new->with('photo')->findOrFail($id);

        return response()->json([
            'new' => $new
        ], 200);
    }

    public function destroy($id)
    {
        $new = $this->new->with('photo')->findOrFail($id);
        $attachment = $new->photo;

        Storage::disk('my_files')->delete($attachment->path);

        $attachment->delete();
        $new->delete();

        return response()->json([
            'msg' => 'Новость была успешно удалена.',
            'news' => $this->new->with('user')->get()
        ], 200);
    }

    public function create(NewRequest $request)
    {
        $attachment = new Attachment;
        $attachment->path = $attachment->upload($request->attachment, 'my_files', 'uploads/news');
        $attachment->save();

        $this->new->create([
            'title' => $request->name,
            'text' => $request->text,
            'file_id' => $attachment->id,
            'user_id' => \Auth::user()->id,
        ]);

        return response()->json([
            'msg' => 'Новость была успешно создана.'
        ], 200);
    }

    public function update(NewRequest $request, $id)
    {
        $new = $this->new->with('photo')->findOrFail($id);

        if ($request->has('attachment')) {
            $attachment = $new->photo;
            Storage::disk('my_files')->delete($attachment->path);

            $attachment->update([
                'path' => $attachment->upload($request->attachment, 'my_files', 'uploads/news'),
            ]);
        }

        $new->update([
            'title' => $request->name,
            'text' => $request->text,
        ]);

        return response()->json([
            'msg' => 'Новость была успешно обновлена.'
        ], 200);
    }
}
