<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsOwner
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
        $user = Auth::user();

        // Auth::logout();
        // return redirect('/login');

        if ($user && !empty($user->email_verified_at) && session('is_owner')) {
            return $next($request);
        }
        return redirect('/')->with('status', 'You are not authorized');
    }
}
