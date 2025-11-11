<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'password',
        'role',
        'is_driver'
    ];
}
