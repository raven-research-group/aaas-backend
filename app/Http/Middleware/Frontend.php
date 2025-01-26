<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Frontend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $header = $request->header("X_FRONTEND_KEY");
        if($header !== env("X_FRONTEND")){
            return response()->json(["message" => "Unauthorized"], 401);
        }

        $whitelisted = explode(",", env("FRONTEND_IPS"));
        $request_ip = $request->ip();
        $is_whitelisted = in_array($request_ip, $whitelisted);

        if(!$is_whitelisted){
            return response()->json(["message" => "Unauthorized"], 401);
        }

        return $next($request);
    }
}
