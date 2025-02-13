<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * Return a successful API response.
     *
     * @param string $message
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse(string $message, $data = [], int $code = 200)
    {
        return response()->json([
            'status_code' => config('status.success.code'),
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Return a failed API response.
     *
     * @param string $message
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse(string $message, $data = [], int $code = 400)
    {
        return response()->json([
            'status_code' => config('status.error.code'),
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
