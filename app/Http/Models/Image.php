<?php

namespace App\Http\Models;

use App\Storage\File;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'origin_width', 'origin_height', 'extension',
    ];

    public static function make(UploadedFile $file): Image
    {
        $image = \Intervention\Image\Facades\Image::make($file);

        $model = new Image();
        $model->origin_width = $image->width();
        $model->origin_height = $image->height();
        $model->extension = $file->getClientOriginalExtension();
        $model->save();

        File::storeImage($file, $model->id);

        return $model;
    }
}
