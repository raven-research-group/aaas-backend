<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

trait RequestValidationTrait
{
    use ApiResponseTrait;

    public function validateOrganizationGetToken($request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "api_secret" => "required|string",
        ]);

        if ($validator->fails()) {
           return $this->errorResponse($validator->errors());
        }
        return true;
    }
}
