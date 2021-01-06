<?php

namespace App\Http\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements JWTSubject, AuthenticatableContract
{
    use Authenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'middle_name', 'gender', 'email',
        'phone_number', 'role', 'birth_date', 'employee_code', 'image_id',
        'company_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public static function makeEmployeeCode($length = 8): string
    {
        do {
            $code = '';

            for ($i = 0; $i < $length; $i++) {
                $code .= mt_rand(0, 9);
            }
        } while (User::where('employee_code', '=', $code)->count());

        return $code;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
