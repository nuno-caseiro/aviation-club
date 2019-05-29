<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class userAtive
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

        if (Auth::user()){
            $user=User::findOrFail(Auth::id());
            if($user->ativo==1){
                return $next($request);
            }else{
                throw new AccessDeniedHttpException('Unauthorized.');

            }

        }
    }
}
