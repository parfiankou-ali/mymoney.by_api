<?php

namespace App\Http\Controllers\v1_0;

use App\Http\Controllers\Controller;

use App\Exceptions\Http\Company\CompanyNotFoundHttpException;
use App\Exceptions\Http\Company\CompanyHasEmployeesHttpException;
use App\Exceptions\Http\User\UserHasNoPermissionsHttpException;
use App\Exceptions\Http\User\UserAlreadyInCompanyHttpException;

use App\Http\Enums\UserRole;

use App\Http\Models\User;
use App\Http\Models\Company;

use App\Http\Requests\v1_0\CompanyCreateRequest;
use App\Http\Requests\v1_0\CompanyDeleteRequest;
use App\Http\Requests\v1_0\CompanyGetRequest;
use App\Http\Requests\v1_0\CompanyUpdateRequest;

use App\Http\Resources\v1_0\CompanyResource;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function create(CompanyCreateRequest $request)
    {
        /** @var User $user */
        $user = Auth::guard('api')->user();

        if ($user->company) {
            throw new UserAlreadyInCompanyHttpException();
        }

        DB::transaction(function () use ($request, &$user, &$company) {
            $company = new Company();
            $company->name = $request->input('name');
            $company->save();

            $user->company()->associate($company);
            $user->role = UserRole::OWNER;
            $user->save();
        });

        return response()->json(new CompanyResource($company));
    }

    public function delete(CompanyDeleteRequest $request)
    {
        /** @var User $user */
        $user = Auth::guard('api')->user();

        try {
            /** @var Company $company */
            $company = Company::findOrFail($request->input('id'));
        } catch (ModelNotFoundException $exception) {
            throw new CompanyNotFoundHttpException();
        }

        if (!$user->company || $user->company->id != $request->input('id') || $user->role != UserRole::OWNER) {
            throw new UserHasNoPermissionsHttpException();
        }

        if ($company->users()->count() > 1) {
            throw new CompanyHasEmployeesHttpException();
        }

        DB::transaction(function () use (&$user, &$company) {
            $user->company()->dissociate();
            $user->role = null;
            $user->save();

            $company->delete();
        });

        return $this->getSuccessfulJsonResponse();
    }

    public function update(CompanyUpdateRequest $request)
    {
        /** @var User $user */
        $user = Auth::guard('api')->user();

        try {
            /** @var Company $company */
            $company = Company::findOrFail($request->input('id'));
        } catch (ModelNotFoundException $exception) {
            throw new CompanyNotFoundHttpException();
        }

        if (!$user->company || $user->company->id != $request->input('id') || $user->role != UserRole::OWNER) {
            throw new UserHasNoPermissionsHttpException();
        }

        DB::transaction(function () use (&$request, &$user, &$company) {
            $company->name = $request->get('name');
            $company->save();
        });

        return $this->getSuccessfulJsonResponse();
    }

    public function get(CompanyGetRequest $request)
    {
        try {
            /** @var Company $company */
            $company = Company::findOrFail($request->input('id'));
        } catch (ModelNotFoundException $exception) {
            throw new CompanyNotFoundHttpException();
        }

        /** @var User $user */
        $user = Auth::guard('api')->user();

        if ($user->company_id != $company->id) {
            throw new UserHasNoPermissionsHttpException();
        }

        return response()->json(new CompanyResource($company));
    }
}
