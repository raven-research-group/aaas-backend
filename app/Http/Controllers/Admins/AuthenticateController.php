<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminSignupRequest;
use App\Models\Admin;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{
    //

    public function register(AdminSignupRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        return DB::transaction(function () use ($validatedData) {
            $organization = Organization::firstOrCreate(
                ['name' => $validatedData['organization_name']],
                [
                    'primary_contact' => $validatedData['primary_contact'],
                    'secondary_contact' => $validatedData['secondary_contact'] ?? null,
                ]
            );
            $admin = Admin::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'organization_id' => $organization->id,
            ]);

            return response()->json([
                'status' => config('status.success.code'),
                'message' => 'Signup successful',
                'data' => [
                    'admin' => $admin,
                    'organization' => $organization,
                ],
            ]);
        });
    }



    public function login(AdminLoginRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $admin = Admin::where('email', $validatedData['email'])->first();

        if ($admin && Hash::check($validatedData['password'], $admin->password)) {
            return response()->json([
                'status' => config('status.success.code'),
                'message' => 'Login successful',
                'data' => [
                    'admin' => $admin,
                ],
            ]);
        }
        return response()->json([
            'status' => config('status.error.code'),
            'message' => 'Invalid credentials',
        ]);
    }
}
