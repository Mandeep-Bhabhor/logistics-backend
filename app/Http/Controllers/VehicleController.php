<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\vehicle;
use App\Models\User;

class VehicleController extends Controller
{
    
  public function addVehicle(Request $request)
{
    // ✅ Get the company from IdentifyTenantMiddleware
    $company = app('company');

    // ✅ Validate incoming data
    $validated = $request->validate([
        'vehicle_number' => 'required|string|unique:vehicles,vehicle_number',
        'type' => 'required|in:truck,mini_truck',
        'capacity' => 'nullable|numeric|min:0',
        'driver_id' => 'nullable|exists:users,id',
    ]);

    // ✅ Check if driver belongs to the same company (security sanity check)
    if (!empty($validated['driver_id'])) {
        $driver = User::where('id', $validated['driver_id'])
            ->where('company_id', $company->id)
            ->first();

        if (!$driver) {
            return response()->json(['error' => 'Invalid driver selection.'], 400);
        }
    }

    // ✅ Create the vehicle record
    $vehicle = Vehicle::create([
        'company_id' => $company->id,
        'vehicle_number' => $validated['vehicle_number'],
        'type' => $validated['type'],
        'capacity' => $validated['capacity'] ?? null,
        'driver_id' => $validated['driver_id'] ?? null,
    ]);

    return response()->json([
        'message' => 'Vehicle added successfully',
        'vehicle' => $vehicle,
    ]);
}
 
public function getVehicles()
{
    // ✅ Get company context from middleware
    $company = app('company');

    // ✅ Fetch all vehicles for this company, with driver info
    $vehicles = \App\Models\Vehicle::with(['driver:id,name,email,is_driver'])
        ->where('company_id', $company->id)
        ->get(['id', 'vehicle_number', 'type', 'capacity', 'driver_id', 'created_at']);

    // ✅ Optionally group by vehicle type (nice for frontend display)
    $grouped = [
        'trucks' => $vehicles->where('type', 'truck')->values(),
        'mini_trucks' => $vehicles->where('type', 'mini_truck')->values(),
        'all' => $vehicles->values(),
    ];

    return response()->json($grouped);
}

}
