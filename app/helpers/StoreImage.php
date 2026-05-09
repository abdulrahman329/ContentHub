<?php

use Illuminate\Http\UploadedFile;

if (! function_exists('storeImage')) {
    function storeImage(?UploadedFile $file, string $folder = 'images', string $disk = 'public'): ?string
    {
        if (!$file) {
            return null;
        }

        return $file->store($folder, $disk);
    }
}