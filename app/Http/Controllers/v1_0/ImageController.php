<?php

namespace App\Http\Controllers\v1_0;

use App\Exceptions\Http\ImageFileNotFoundHttpException;
use App\Exceptions\Http\ImageNotFoundHttpException;
use App\Exceptions\Http\UserHasNoPermissionsHttpException;

use App\Http\Controllers\Controller;
use App\Http\Models\Image;
use App\Http\Requests\v1_0\ImageGetRequest;

use App\Storage\File;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ImageController extends Controller
{
    public function get(ImageGetRequest $request)
    {
        try {
            $image = Image::findOrFail($request->input('id'));
        } catch (ModelNotFoundException $exception) {
            throw new ImageNotFoundHttpException();
        }

        /** @var User $user */
        $user = Auth::guard('api')->user();

        if ($user->image_id != $image->id && ($image->user == null || $image->user->company_id == null || $user->company_id != $image->user->company_id)) {
            throw new UserHasNoPermissionsHttpException();
        }

        $directory = File::getImageDirectory($image->id);
        $path = File::getImagePath($directory, $image->extension, $request->input('size'));

        if (!file_exists($path)) {
            throw new ImageFileNotFoundHttpException();
        }

        $file = new \Illuminate\Http\File($path);
        $image = \Intervention\Image\Facades\Image::make($file);

        return new BinaryFileResponse($file, Response::HTTP_OK, [
            'Content-Type' => $image->mime(),
        ]);
    }
}
