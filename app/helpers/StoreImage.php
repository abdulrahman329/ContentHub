<?php

// This helper function stores an uploaded image file in the specified folder within the public disk and returns the path to the stored image.
if (! function_exists('storeImage')) {
    function storeImage($file, $folder = 'images'): string
    {
        return $file->store($folder, 'public');
    }
}