<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadFileTrait
{
    const DISK = 'public';

    public static function uploadFile(UploadedFile $file, string $folder = null): string
    {
        $folder = $folder ?? strtolower(implode('_', explode('\\', get_called_class())));

        $fileName = $folder . '/' . time() . '_' . \Str::random(10) . '.' . $file->getClientOriginalExtension();
        Storage::disk(self::DISK)->put($fileName, $file->getContent());

        return $fileName;
    }

    public static function deleteFile(string $fileName = null)
    {
        if ($fileName) {
            Storage::disk(self::DISK)->delete($fileName);
        }
    }
}