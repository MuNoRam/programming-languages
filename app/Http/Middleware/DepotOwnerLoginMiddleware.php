<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class DepotOwnerLoginMiddleware
{


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $error = false ;
        $saved_Login = null;
        if(!$request->hasHeader('Login'))
        {
            $error = true ;
            return response()->json([
                'message' => 'Invalid Login'
            ]);
        }

        else{
            $token = $request->header('Login');
            $token = Hash::make($token);
            if(!$saved_Login){
                $saved_Login = $token ;
                return $next($request);
            }
            else{
                if($token != $saved_Login){
                    $error = true ;
                    return response()->json([
                        'message' => 'E-mail or password is incorrect'
                    ]);
                }
                else{
                    return $next($request);
                }

            }
        }
    }
}
