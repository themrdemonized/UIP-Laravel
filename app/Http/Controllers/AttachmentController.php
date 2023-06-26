<?php

namespace App\Http\Controllers;

use App\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    private $attachment;

    public function __construct(Attachment $attachment)
    {
        $this->attachment = $attachment;
    }

    public function delete($id)
    {
        $attachment = $this->attachment->findOrFail($id);
        Storage::disk('my_files')->delete($attachment->path);
        $attachment->delete();

        return response()->json([
            'msg' => 'Файл был успешно удален.',
        ], 200);
    }
}
