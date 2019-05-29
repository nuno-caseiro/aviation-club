<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class checkInitPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()&&Auth::user()->password_inicial==0){

            return $next($request);
            //
        }

        throw new AccessDeniedHttpException('Unauthorized.');



    }
}
