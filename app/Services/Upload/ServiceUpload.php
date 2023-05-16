<?php

namespace App\Services\Upload;

use Illuminate\Support\Str;

class ServiceUpload
{
    public function singleUpload($path, $file)
    {
        $fileName = Str::random(4) . "-" . time() . '.' . $file->extension();
        $file->move(public_path($path), $fileName);
        return $fileName;
    }
}
