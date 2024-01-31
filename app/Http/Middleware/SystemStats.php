<?php

namespace App\Http\Middleware;

use App\Http\Controllers\StatsController;
use App\Models\CookieToUrl;
use Closure;
use Auth;
use App\Http\Controllers\LocationAccessController;

class SystemStats
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $visited = $request->cookie('visited');
        if (!$visited) {
            $fullUrl = $request->fullUrl();
            $host = $request->headers->get('referer');
            $target = $request->target;
            $source = $request->source;
            $device = $request->device;
            if (!$target) {
                $target = 1;
                //1 - basic 2 - not valid number
            }

            $cookie = uniqid();
            $cookieToUrl = CookieToUrl::where('cookie', $cookie)
                ->where('target', $target)->first();

            if (!$cookieToUrl) {
                if (strlen($host) >= 190) {
                    $host = substr($host, 0, 190);
                }
                $cookieToUrl = new CookieToUrl();
                $cookieToUrl->target = $target;
                $cookieToUrl->source = $source;
                $cookieToUrl->device = $device;
                $cookieToUrl->cookie = $cookie;
                $cookieToUrl->host = $host;
                $cookieToUrl->url = $fullUrl;
                $cookieToUrl->save();
            }

            $response = $next($request);
            return $response->withCookie(cookie()->forever('visited', $cookie));
        }
        return $next($request);
    }
}
