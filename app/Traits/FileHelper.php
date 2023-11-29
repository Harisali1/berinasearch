<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait FileHelper
{
    public function saveFileAndGetPath($file, $folderPath)
    {
        $image = Str::replace('data:image/png;base64,', '', $file);
        $image = Str::replace(' ', '+', $image);
        $imageName = Str::random(10) . '.' . 'png';
        File::put(public_path() . $folderPath . '/' . $imageName, base64_decode($image));
        $path = $folderPath .'/'. $imageName;
        return $path;
    }

}
