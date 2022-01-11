<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsTeacher
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

        if ($user && !empty($user->email_verified_at) && has_role($user, 'owner|student|teacher')) {
            return $next($request);
        }
        session()->flush();
        return redirect()->route('login')->with('status', 'You are not authorized');
    }
}
