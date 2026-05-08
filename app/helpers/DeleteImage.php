<?php 
use Illuminate\Support\Facades\Storage;

// This helper function deletes an image from the storage if it exists and is not the default user image.
if (!function_exists('deleteImage')) {
    function deleteImage($path): void
    {
        // Check if the path is valid, not the default user image, and exists in the public disk before deleting.
        if (
            $path &&
            $path !== 'images/user_image.png' &&
            Storage::disk('public')->exists($path)
        ) {
            Storage::disk('public')->delete($path);
        }
    }
}