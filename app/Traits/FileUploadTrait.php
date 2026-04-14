<?php

namespace App\Traits;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait FileUploadTrait
{
    public function uploadFile(UploadedFile $file, $path = 'uploads'): ?string
    {
        if(!$file->isValid()){
            return null;
        }

        $folderPath = public_path($path);

        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
        
        $file->move($folderPath, $filename);

        $filepath = $path.'/'.$filename;

        return $filepath;
    }
}