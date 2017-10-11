<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Closure;

class TestUA
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
        $agent = new Agent();
        $flag = false;
        switch($agent->browser()) {
            case "Chrome":
                if($agent->version($agent->browser()) < 39)
                    $flag = true;
                break;
            case "Firefox":
                if($agent->version($agent->browser()) < 34)
                    $flag = true;
                break;
            case "Opera":
                if($agent->version($agent->browser()) < 26)
                    $flag = true;
                break;
            case "Safari":
                if($agent->version($agent->browser()) < 8)
                    $flag = true;
                break;
            case "IE":
                if($agent->version($agent->browser()) < 11)
                    $flag = true;
                break;
        }
        Session::forget('old_browser');
        if($flag)
            Session::put('old_browser',true);
        return $next($request);
    }
}
