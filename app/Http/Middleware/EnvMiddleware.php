<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnvMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasHeader('Authorization')) {
            abort(401, 'Unauthorized');
        }

        $APIToken = $_ENV['API_TOKEN'];

        if (!$request->header('Authorization') == $APIToken) {
            abort(401, 'Unauthorized');
        }
        return $next($request);

    }
}
