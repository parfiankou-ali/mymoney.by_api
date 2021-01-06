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
        'original_width', 'original_height', 'extension',
    ];

    public static function make(UploadedFile $file): Image
    {
        $image = \Intervention\Image\Facades\Image::make($file);

        $model = new Image();
        $model->original_width = $image->width();
        $model->original_height = $image->height();
        $model->extension = $file->getClientOriginalExtension();
        $model->save();

        File::storeImage($file, $model->id);

        return $model;
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
