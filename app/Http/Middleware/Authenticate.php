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
            if (isset($request->user_id) && $request->user_id != $request->session()->get('user_id'))
                return Redirect::to('/user/' . $request->session()->get('user_id'));
            return $next($request);
        }
        else
        {
            return Redirect::to('/login');
        }
    }
}
