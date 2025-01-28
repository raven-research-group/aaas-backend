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
use App\Traits\ApiResponseTrait;

class AuthenticateController extends Controller
{
    //
    use ApiResponseTrait;

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
            $data = [
                'admin' => $admin,
                'organization' => $organization,
            ];
            return $this->successResponse('sign up successful', $data);
        });
    }



    public function login(AdminLoginRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $admin = Admin::where('email', $validatedData['email'])->first();


        if ($admin && Hash::check($validatedData['password'], $admin->password)) {
            $token = $admin->createToken('frontend')->accessToken;

            $data = [
                'admin' => $admin,
                'token' => $token,
            ];
            return $this->successResponse('Log in successful', $data);
        }
        return $this->errorResponse('Invalid credentials');
    }
}
