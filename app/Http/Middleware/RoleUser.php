<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = auth()->user();
        if(empty($user->email_verified_at)) {
            return redirect()->route('login')->with('status', 'Please verify your account');
        } elseif(has_role($user, $role)) {
            return $next($request);
        } else {
            // session()->flush();
            return redirect()->route('/')->with('status', 'You are not authorized');
        }
    }
}
