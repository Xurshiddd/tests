<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

//    use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Image;

trait ImageUpload
{
    /**
     * Upload an image to the specified directory, converting it to WebP format.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return string
     */
    public function uploadImage(UploadedFile $file, $directory)
    {
        $path = public_path($directory);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $filename = time() . '_' . $file->getClientOriginalName();
        $destinationPath = public_path($directory);
        $file->move($destinationPath, $filename);
        $filePath = $directory . '/' . $filename;
        return $filePath;
    }

    /**
     * Delete an image from the public directory.
     *
     * @param string $path
     * @return void
     */
    public function deleteImage($path)
    {
        if (!empty($path)) {
            $fullPath = public_path($path);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }

    /**
     * Replace an old image with a new one, converting it to WebP format.
     *
     * @param UploadedFile $file
     * @param string $oldPath
     * @param string $directory
     * @return string
     */
    public function replaceImage(UploadedFile $file, $oldPath, $directory)
    {
        $this->deleteImage($oldPath);
        return $this->uploadImage($file, $directory);
    }
}
