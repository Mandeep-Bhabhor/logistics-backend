<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vehicle extends Model
{
    protected $fillable =[
       'company_id',
       'vehicle_number',
       'type',
       'capacity',
       'driver_id',
       

    ];
}
