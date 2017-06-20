<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Authenticate
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
        if($request->session()->has('user_id'))
        {
            return $next($request);
        }
        else
        {
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false
                && !$request->session()->has('wechat_open_id')
            ) {
                return Redirect::to('/wx');
            }
            return Redirect::to('/login');
        }
    }
}
