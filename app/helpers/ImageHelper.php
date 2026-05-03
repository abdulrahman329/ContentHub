<?php 
use Illuminate\Support\Facades\Storage;

if (!function_exists('deleteImage')) {
    function deleteImage($path)
    {
        if (
            $path &&
            $path !== 'images/user_image.png' &&
            Storage::disk('public')->exists($path)
        ) {
            Storage::disk('public')->delete($path);
        }
    }
}