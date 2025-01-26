<?php

namespace App\Http\Controllers\Organizations;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthenticateController extends Controller
{
    //
    public function token(Request $request){

        $creds = $request->only("name","api_secret");
        Log::info(json_encode($creds));

        $organization = Organization::where("name",$creds["name"])->where("api_secret",$creds["api_secret"])->first();

        if(!$organization){
            return response()->json([
                "message" => "Invalid credentials"
            ],401);
        }

        $token = $organization->createToken('frontend')->accessToken;

        return response()->json([
            "message" => "Token generated successfully",
            "data" => [
                "token" => $token
            ]
        ]);

    }


}