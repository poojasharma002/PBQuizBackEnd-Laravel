<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class VerifyUser
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
            $user = User::where('token', $headerToken)->first();
            if (!$user) {

                $data = [
                    'success' => false,
                    'data' => null,
                    'error' => 'User not found',
                    'status' => 400
                ];
                return response()->json($data)->setStatusCode(401);
            }else{
                return $next($request);
            }
        }
    }
}
