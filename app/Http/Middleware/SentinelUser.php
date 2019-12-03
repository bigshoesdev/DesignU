<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Redirect;

class SentinelUser
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

        if (!Sentinel::check()) {
            if ($request->ajax()) {
                return response(json_encode(['success' => false, 'msg' => 'unauthorized']), 401);
            } else {
                $request->session()->put('returnUrl', $request->url());
                return Redirect::route('auth.login');
            }
        }
        return $next($request);
    }
}
