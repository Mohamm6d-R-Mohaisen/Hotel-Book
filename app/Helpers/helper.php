<?php
use Illuminate\Support\Facades\Storage;
function admin()
{
    if (auth()->guard('admin')->check()) {
        return auth()->guard('admin')->user();
    }
}
function getImageUrl($imagePath, $size = 'original')
{
    return Storage::url(str_replace('_original', "_$size", $imagePath));
}
