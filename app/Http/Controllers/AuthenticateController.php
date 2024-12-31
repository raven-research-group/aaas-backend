<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends Controller
{
    //
    
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



    // password reset
    public function resetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'old_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:' . config('requestBody.passwordMin.length'),
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
        ], [
            'new_password.regex' => config('requestBody.passwordRegex.message'),
            'new_password.min' => config('requestBody.passwordMin.message'),
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => config('status.error.code'),
                'message' => $validate->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => config('status.error.code'),
                'message' => 'User not found',
            ], 404);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => config('status.error.code'),
                'message' => 'Invalid old password',
            ], 401);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => config('status.success.code'),
            'message' => 'Password reset successful',
        ], 200);
    }
}
