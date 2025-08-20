<?php
namespace App\Traits;

use App\Models\Image;

trait HasImages{
public function storeModelImages($model, $images)
{
    $folder = $model->getTable();
    foreach ($images as $imageFile) {
        $filename = $this->saveImage($imageFile, $folder);
            $model->images()->create([
                'image' => $filename,
            ]);

    }
}

    public function updateModelImages($model, $images, $existingIds = [], $existingPaths = [])
    {
        // حذف الصور غير الموجودة في الـ request
        $model->images()
            ->whereNotIn('id', $existingIds)
            ->each(function ($image) {
                $this->deleteImage($image->image); // حذف من السيرفر
                $image->delete(); // حذف من قاعدة البيانات
            });

        foreach ($existingIds as $index => $id) {
            $existingImage = $model->images->firstWhere('id', $id);
            if (!$existingImage) continue;

            $newImageFile = $images[$index] ?? null;
            $currentPath = $existingPaths[$index] ?? null;

            if ($newImageFile instanceof \Illuminate\Http\UploadedFile) {
                // تم رفع صورة جديدة → حذف القديمة + حفظ الجديدة
                $this->deleteImage($existingImage->image);
                $newPath = $this->saveImage($newImageFile, $model);
                $existingImage->update(['image' => $newPath]);
            } else {
                // لم يتم تغيير الصورة → لا حاجة لتعديل
            }
        }
    }

}
