<?php

namespace App\Http\Middleware;

use App\Via;
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
            if(isset($request->via) && $request->via) {
                if(Via::where('name', $request->via)->count() > 0) {
                    $via = Via::where('name', $request->via)->first();
                } else {
                    $via = new Via();
                    $via->name = $request->via;
                    $via->count = 0;
                }
                $via->count++;
                $via->save();
            }
        }
        return $next($request);
    }
}
