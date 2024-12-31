<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Create a new user
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'type' => 'required|in:' . config('requestBody.user.type'),
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
        ], [
            'password.regex' => 'The password must contain at least 8 characters, including at least one uppercase letter, one number, and one special character (e.g., @, $, !, %, *, ? or &).',
            'password.min' => 'The password must be at least 8 characters long.',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => config('status.error.code'),
                'message' => $validate->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type
        ]);

        return response()->json([
            'status' => config('status.success.code'),
            'message' => 'User created successfully',
            'data' => $user->only(['name', 'email', 'type', 'primary_contact', 'secondary_contact'])
        ], 201);
    }



        // Login user
        public function login(Request $request)
        {
            $validate = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            if ($validate->fails()) {
                return response()->json([
                    'status' => config('status.error.code'),
                    'message' => $validate->errors(),
                ], 422);
            }
    
            $user = User::where('email', $request->email)->first();
    
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => config('status.error.code'),
                    'message' => 'Invalid credentials',
                ], 401);
            }
    
            return response()->json([
                'status' => config('status.success.code'),
                'message' => 'Login successful',
                'data' => [
                    'user' => $user->only(['name', 'email', 'type', 'primary_contact', 'secondary_contact']),
                ],
            ], 200);
        }
}
