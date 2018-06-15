<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;

class TestUA
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
        $agent = new Agent();
        $flag = false;
        switch ($agent->browser()) {
            case "Chrome":
                if ($agent->version($agent->browser()) < 24) {
                    $flag = true;
                }
                break;
            case "Firefox":
                if ($agent->version($agent->browser()) < 24) {
                    $flag = true;
                }
                break;
            case "Opera":
                if ($agent->version($agent->browser()) < 15) {
                    $flag = true;
                }
                break;
            case "Safari":
                if ($agent->version($agent->browser()) < 7) {
                    $flag = true;
                }
                break;
            case "IE":
                if ($agent->version($agent->browser()) < 10) {
                    $flag = true;
                }
                break;
        }
        Session::forget('old_browser');
        if ($flag) {
            Session::put('old_browser', true);
        }

        return $next($request);
    }
}
