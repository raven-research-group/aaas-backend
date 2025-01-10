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
                'min:'.config('requestBody.passwordMin.length'),
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
        ], [
            'password.regex' => config('requestBody.passwordRegex.message'),
            'password.min' => config('requestBody.passwordMin.message'),
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => config('status.error.code'),
                'message' => $validate->errors()
            ], 400);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json([
                'status' => config('status.error.code'),
                'message' => 'User already exists'
            ], 400);
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


}
