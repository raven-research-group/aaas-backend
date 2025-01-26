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
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;



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




    


public function login(AdminLoginRequest $request, AuthorizationServer $server, ServerRequestInterface $psrRequest): JsonResponse
{
    $validatedData = $request->validated();
    $admin = Admin::where('email', $validatedData['email'])->first();

    if ($admin && Hash::check($validatedData['password'], $admin->password)) {
        $request->merge([
            "client_secret" => $admin->client_secret,
            "client_id" => $admin->client_id,
            "grant_type" => "password",
            "username" => $validatedData['email'],
            "password" => $validatedData['password'],
            "scope" => "",
        ]);

        $psrRequest = $psrRequest->withParsedBody($request->all());

        try {
            $psrResponse = new Response();

            // Generate token
            $response = $server->respondToAccessTokenRequest($psrRequest, $psrResponse);
            $tokenData = json_decode((string) $response->getBody(), true);

            if (isset($tokenData['access_token'])) {
                return response()->json([
                    'status' => config('status.success.code'),
                    'message' => 'Login successful',
                    'data' => [
                        'admin' => $admin,
                        'token' => $tokenData['access_token'],
                    ],
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => config('status.error.code'),
                'message' => 'Unable to authenticate',
                'error' => $e->getMessage(),
            ], 401);
        }
    }

    return response()->json([
        'status' => config('status.error.code'),
        'message' => 'Invalid credentials',
    ]);
}

    
}
