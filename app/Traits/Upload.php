<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait Upload
{
    public function upload($file, $storage = 'my_files', $folder = '')
    {
        $filename = uniqid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        $path = Storage::disk($storage)->putFileAs($folder, $file, $filename);

        if (Storage::disk($storage)->exists($path)) {
            return $path;
        }

        return null;
    }
}
