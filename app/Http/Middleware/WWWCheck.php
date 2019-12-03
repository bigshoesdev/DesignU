<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use URL;
use Redirect;

class WWWCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $hostAddress = $request->fullUrl();

        if(strpos($hostAddress, 'www.')) {
            $hostAddress = str_replace('www.',"",$hostAddress);

            return redirect($hostAddress);
        }

        return $next($request);
    }
}
