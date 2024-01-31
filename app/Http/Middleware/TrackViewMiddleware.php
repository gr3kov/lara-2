<?php

// app/Http/Middleware/TrackViewMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class TrackViewMiddleware
{
    public function handle($request, Closure $next)
    {
        $viewName = View::getName();
        // Сохраните $viewName в сеансе, журнале или другом месте
        return $next($request);
    }
}
