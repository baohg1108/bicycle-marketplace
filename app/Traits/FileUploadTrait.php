<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait FileUploadTrait
{
    public function uploadFile(UploadedFile $file, ?string $oldPath = null, ?string $path = 'uploads'): ?string
    {
        if (! $file->isValid()) {
            return null;
        }

        $ignorePath = ['/default/avatar.png', '/defaults/shop.png', '/defaults/banner.png'];

        if ($oldPath && File::exists(public_path($oldPath)) && ! in_array($oldPath, $ignorePath)) {
            File::delete(public_path($oldPath));
        }

        $folderPath = public_path($path);

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $file->move($folderPath, $filename);

        $filepath = $path . '/' . $filename;

        return $filepath;
    }

    public function uploadPrivateFile(UploadedFile $file, ?string $oldPath = null, ?string $path = 'uploads'): ?string
    {
        if (! $file->isValid()) {
            return null;
        }

        // $ignorePath = ['/default/avatar.png'];

        // if ($oldPath && File::exists(public_path($oldPath)) && !in_array($oldPath, $ignorePath)) {
        //     File::delete(public_path($oldPath));
        // }

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs($path, $filename, 'local');

        return $path;
    }

    public function deleteFile(string $path): bool
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
            return true;
        }
        return false;
    }
}