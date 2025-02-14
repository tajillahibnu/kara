<?php

namespace Modules\Pkl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AppMetaMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        view()->share('siteMeta', getSiteMeta());
        return $next($request);
    }
}
