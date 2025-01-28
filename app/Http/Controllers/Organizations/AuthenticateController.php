<?php

namespace App\Http\Controllers\Organizations;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\ApiResponseTrait;
use App\Traits\RequestValidationTrait;

class AuthenticateController extends Controller
{
    //
    use ApiResponseTrait;
    use RequestValidationTrait;


    public function token(Request $request)
    {

        $validation = $this->validateOrganizationGetToken($request);
        if ($validation !== true) {
            return $validation;
        }
        $creds = $request->only("name", "api_secret");

        $organization = Organization::where("name", $creds["name"])->where("api_secret", $creds["api_secret"])->first();

        if (!$organization) {
            return $this->errorResponse("Invalid credentials");
        }

        $token = $organization->createToken('frontend')->accessToken;
        $data = [
            "token" => $token
        ];
        return $this->successResponse("Token generated successfully", $data);
    }
}
