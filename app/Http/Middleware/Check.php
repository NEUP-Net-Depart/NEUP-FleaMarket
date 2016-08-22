<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Check
{
    public function handle($request, Closure $next)
    {
        if($request->session()->has('username')&&$request->session()->has('is_admin'))
        {
            return $next($request);
        }
        else
        {
            return Redirect::to('/login');
        }
    }
}