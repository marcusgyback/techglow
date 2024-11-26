<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetPartnerCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->hasCookie('partner')) {
            return $next($request);
        }

        $time = time() + 60 * 60 * 15; //15 days
        $cookieValue = $request->partner;
        $res = $next($request);
        return $res->cookie('partner', $cookieValue, $time, "/");
    }
}
