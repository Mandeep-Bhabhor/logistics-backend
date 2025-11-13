<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class vehicle extends Model
{
    protected $fillable =[
       'company_id',
       'vehicle_number',
       'type',
       'capacity',
       'driver_id',
       

    ];

    public function driver()
{
    return $this->belongsTo(User::class, 'driver_id');
}
}
