<?php

namespace App\Http\Controllers\v1_0;

use App\Exceptions\Http\InvalidCredentialsHttpException;
use App\Exceptions\Http\UserNotFoundHttpException;

use App\Http\Controllers\Controller;

use App\Http\Models\Image;
use App\Http\Models\User;

use App\Http\Requests\v1_0\UserGetRequest;
use App\Http\Requests\v1_0\UserSignInRequest;
use App\Http\Requests\v1_0\UserSignUpRequest;

use App\Http\Resources\v1_0\UserResource;
use App\Http\Resources\v1_0\UserSimplifiedResource;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public function signUp(UserSignUpRequest $request)
    {
        DB::transaction(function () use ($request, &$user) {
            $image = Image::make($request->file('image'));

            $user = new User($request->only([
                'first_name', 'last_name', 'middle_name',
                'gender', 'phone_number', 'email',
            ]));
            $user->birth_date = Carbon::parse($request->input('birth_date'));
            $user->password = app('hash')->make($request->input('password'));
            $user->employee_code = User::makeEmployeeCode();
            $user->image()->associate($image);
            $user->save();
        });

        $token = Auth::guard('api')->login($user);

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    public function signIn(UserSignInRequest $request)
    {
        if (!$token = Auth::guard('api')->attempt($request->only(['email', 'password']))) {
            throw new InvalidCredentialsHttpException();
        }

        return response()->json([
            'user' => new UserResource(Auth::guard('api')->user()),
            'token' => $token,
        ]);
    }

    public function get(UserGetRequest $request)
    {
        try {
            $user = User::findOrFail($request->input('id'));
        } catch (ModelNotFoundException $exception) {
            throw new UserNotFoundHttpException();
        }

        return response()->json(new UserSimplifiedResource($user));
    }
}
