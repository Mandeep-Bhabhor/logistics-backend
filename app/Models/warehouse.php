<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class warehouse extends Model
{
    //
    protected $fillable = [
        'company_id',
        'name',
        'location',
        'capacity',
        'manager_id'
    ];
}
