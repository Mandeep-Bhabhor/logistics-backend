<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    //
    public function addwarehouse(Request $request)
    {
         $company = app('company');

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'capacity' => 'nullable|numeric',
        'manager_id' => 'required|exists:users,id',
    ]);

    $warehouse = \App\Models\Warehouse::create([
        'company_id' => $company->id,
        'name' => $validated['name'],
        'location' => $validated['location'],
        'capacity' => $validated['capacity'] ?? null,
        'manager_id' => $validated['manager_id'],
    ]);

    return response()->json($warehouse, 201);

    }
}
