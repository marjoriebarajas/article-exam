<?php

namespace App\Modules\Admin\Middleware;

use Closure;
use Config;
use Illuminate\Support\Facades\Auth;
class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        config(['auth.defaults.guard' => $guard]);
        config(['filesystems.default' => 'public']);
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/login')->with('warning', 'Your session has expired. Please login again.');
            }
        }
        return $next($request);
    }
}
