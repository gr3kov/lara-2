<?php

namespace App\Http\Middleware;

use Closure;

class Age18
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $age18 = true; //$request->cookie('age18');
        if ($age18 == true) {
            return $next($request);
        } else {
            return redirect('/age');
        }
    }
}
