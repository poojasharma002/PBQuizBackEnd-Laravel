<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckHeaderToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $headerToken = $request->header('Authorization');


        if (!$headerToken) {
            $data = [
                'success' => false,
                'data' => null,
                'error' => 'Header token not found',
                'status' => 401
            ];
            return response()->json($data)->setStatusCode(401);
        }else{

            $headerToken = $request->header('Authorization');
            $responseGoogle = Http::get('https://www.googleapis.com/oauth2/v3/userinfo?', [
                'access_token' => $headerToken
            ]);
            if($responseGoogle->clientError()){
                return response()->json('Unauthorized',401);
            }else{
              return $next($request);
            }

        }
        
    }
}
