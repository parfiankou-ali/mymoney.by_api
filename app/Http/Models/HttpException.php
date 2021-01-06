<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class HttpException extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'response', 'status_code',
    ];
}
