<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Subdomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $subdomain = get_subdomain($request->getHost());

        if ($subdomain === 'redirect-app') {

            return redirect()->away(get_protocol() . 'app.' . config('app.short_url'));
        }

        return $next($request);

    }
}
