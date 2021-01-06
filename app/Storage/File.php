<?php

namespace App\Storage;

use App\Http\Enums\ImageSize;

use Intervention\Image\Facades\Image;
use Intervention\Image\Constraint;

use Illuminate\Http\UploadedFile;

abstract class File
{
    public const DefaultImageQuality = 85; // 0 to 100

    public static function storeImage(UploadedFile $file, int $id)
    {
        $directory = static::getImageDirectory($id);

        static::makeDirectory($directory);

        static::storeSquareImage($file, $directory);
        static::storeImageReplicas($file, $directory);
        static::storeOriginalImage($file, $directory);
    }

    public static function storeSquareImage(UploadedFile $file, string $directory)
    {
        $path = static::getImagePath($directory, $file->getClientOriginalExtension(), ImageSize::SQUARE_128);

        $image = Image::make($file);
        $image->fit(ImageSize::MAX_128, null, function (Constraint $constraint) {
            $constraint->upsize();
        });
        $image->save($path, static::DefaultImageQuality);
    }

    public static function storeImageReplicas(UploadedFile $file, string $directory)
    {
        $originalImage = Image::make($file);
        $replicas = static::getAvailableImageReplicaSizesByDimensions($originalImage->width(), $originalImage->height());

        foreach ($replicas as $replica) {
            $image = Image::make($file);
            $path = static::getImagePath($directory, $file->getClientOriginalExtension(), $replica);

            if ($image->width() >= $image->height()) {
                $image->widen($replica);
            } else {
                $image->heighten($replica);
            }

            $image->save($path, static::DefaultImageQuality);
        }
    }

    public static function storeOriginalImage(UploadedFile $file, string $directory)
    {
        $fileName = ImageSize::ORIGINAL;
        $extension = $file->getClientOriginalExtension();

        $file->move($directory, "${fileName}.$extension");
    }

    public static function getImageDirectory(int $id)
    {
        return storage_path("app/images/users/${id}");
    }

    public static function getImagePath(string $directory, string $extension, string $size): string
    {
        return "${directory}/${size}.${extension}";
    }

    public static function makeDirectory(string $path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    public static function getAvailableImageReplicaSizesByDimensions(int $width, int $height)
    {
        $replicas = [];

        foreach (ImageSize::values() as $value) {
            if ($width <= $value && $height <= $value) {
                break;
            }

            $replicas[] = $value;
        }

        return $replicas;
    }
}
