<?php
namespace App\Services;

use Image;
use Illuminate\Support\Facades\Storage;

class UploadFile {
    public function imageUpload($request) {
        $file = $request->image;
        $name = time().'.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
        $image = Image::make($file);
        $image->fit(250, 250, function ($constraint) { $constraint->aspectRatio();});
        Storage::disk('public')->put($name, (string) $image->encode());
        return $name;
    }
}