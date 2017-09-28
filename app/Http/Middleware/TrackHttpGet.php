<?php

namespace App\Http\Middleware;

use Closure;

class TrackHttpGet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $blacklist = [
        "/login",
        "/logout",
        "/register",
        "/wx",
        "/sso",
        "/message/get",
        "/titlepic",
        "/avatar"
    ];

    public function handle($request, Closure $next)
    {
        if($request->isMethod("GET")) {
            $uri = $request->getRequestUri();
            $save = true;
            foreach ($this->blacklist as $b) {
                if (strpos($uri, $b) !== false) {
                    $save = false;
                    break;
                }
            }
            if ($save) {
                $request->session()->put('lastGetUri', $uri);
            }
        }
        return $next($request);
    }
}
