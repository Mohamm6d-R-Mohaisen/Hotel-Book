<?php

namespace App\Traits;

trait SaveImageTrait
{
    public function saveImage($file, $path = '')
    {
        $file_exe = $file->getClientOriginalExtension();
        $new_name = uniqid() . '.' . $file_exe;
        $directory = 'uploads' . '/' . 'store' . '/' . $path;
        $destienation = public_path($directory);
        $file->move($destienation, $new_name);
        return '/' . $directory . '/' . $new_name;
    }

    public function deleteImage($imagePath)
    {
        if ($imagePath && file_exists(public_path(ltrim($imagePath, '/')))) {
            unlink(public_path(ltrim($imagePath, '/')));
            return true;
        }
        return false;
    }
}
