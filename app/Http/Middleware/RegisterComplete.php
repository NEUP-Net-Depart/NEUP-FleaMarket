<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Redirect;

class RegisterComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('user_id')) {
            $user = User::find($request->session()->get('user_id'));
            if ($user->registerCompletion(true)) {
                return Redirect::to('/register/'.$user->registerCompletion(true));
            }

            return $next($request);
        } else {
            return Redirect::to('/login');
        }
    }
}
