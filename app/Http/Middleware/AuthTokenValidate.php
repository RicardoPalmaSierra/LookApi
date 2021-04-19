<?php

namespace App\Http\Middleware;

use App\Enum\ECodeStatus;
use App\Helpers\Helpers;
use App\Helpers\JwtAuth;
use Closure;
use Illuminate\Http\Request;

class AuthTokenValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $auth = new JwtAuth();
        $token = $request->header("Authorization");
        $check = $auth->checkToken($token);
        if($check){
            return $next($request);
        }else{
            return response()->json(Helpers::response(ECodeStatus::Unauthorized, null, "Usuario no autenticado"));
        }
        return $next($request);
    }
}
