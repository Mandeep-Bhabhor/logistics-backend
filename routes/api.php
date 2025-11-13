<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\WarehouseController;
use App\Models\Company;
use App\Models\warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/companies', function () {
    return Company::select('id', 'name', 'subdomain')->get();
});

Route::post('/register', [UserController::class, 'register']);
Route::get('/drivers', [UserController::class, 'getdriver']);
Route::get('/staff', [UserController::class, 'getstaff']);

Route::get('/vehicles', [VehicleController::class, 'getvehicles']);

Route::post('/vehicle/add', [VehicleController::class,'addvehicle']);
Route::post('/warehouses/add', [WarehouseController::class,'addwarehouse']);
Route::post('/customers/register', [UserController::class, 'registeruser']);
