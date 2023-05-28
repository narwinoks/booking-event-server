<?php

namespace App\Services\Upload;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UploadServices
{
    public function singleUpload($path, $file)
    {
        $fileName = Str::random(4) . "-" . time() . '.' . $file->extension();
        $file->move(public_path($path), $fileName);
        return $fileName;
    }

    public function deleteFile($path, $file)
    {
        try {
            File::delete($path . $file);
            return true;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
