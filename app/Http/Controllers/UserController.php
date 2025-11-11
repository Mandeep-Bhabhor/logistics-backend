<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // ✅ Get current tenant (company) from middleware
        $company = app('company');

        // ✅ Validate inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // ✅ Check how many users already exist for this company
        $existingUsers = User::where('company_id', $company->id)->count();

        // ✅ If first user → make admin, else staff
        $role = $existingUsers === 0 ? 'company_admin' : 'staff';

        // ✅ Create user
        $user = User::create([
            'company_id' => $company->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'is_driver' => $request->boolean('is_driver', false),
        ]);

        // ✅ Return JSON response
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ]);
    }

    public function getdriver()
    {
        $company = app('company');

        $drivers = User::where('company_id', $company->id)
            ->where('is_driver', 1)
            ->get(['id', 'name', 'email']);

      

        return response()->json($drivers);
    }
}
