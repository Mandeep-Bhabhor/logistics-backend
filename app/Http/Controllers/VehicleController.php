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

}
