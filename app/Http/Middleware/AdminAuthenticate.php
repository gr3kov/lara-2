<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (\Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/login');
            }
        }

        $roleId = \Auth::user()->role_id;
        $isAdmin = true;
        $isManager = true;

        if (isset($roleId)) {
            $role = Role::find($roleId);
            $isAdmin = $role['name'] == 'admin';
            $isManager = $role['name'] == 'manager';
        }

        if ($isAdmin || $isManager) {
            return $next($request);
        } else {
            \Auth::guard($guard)->logout();
            return response('Access denied.', 401);
        }
    }
}
