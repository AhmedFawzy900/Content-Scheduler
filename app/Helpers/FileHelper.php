<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function uploadImage(UploadedFile $file, string $path = 'posts'): string
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs($path, $fileName, 'public');
        return Storage::url($filePath);
    }

    public static function deleteImage(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        $relativePath = str_replace('/storage/', '', $path);
        return Storage::disk('public')->delete($relativePath);
    }

    public static function getFileExtension(UploadedFile $file): string
    {
        return $file->getClientOriginalExtension();
    }

    public static function getFileSize(UploadedFile $file): int
    {
        return $file->getSize();
    }

    public function uploadFile(UploadedFile $file, string $directory): string
    {
        $path = $file->store($directory, 'public');
        return Storage::url($path);
    }

    public function deleteFile(string $path): bool
    {
        if (Storage::exists($path)) {
            return Storage::delete($path);
        }
        return false;
    }
} 