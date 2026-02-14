<?php

namespace App\Http\Middleware;

use Closure;

class Verified
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
        $user = $request->user();

        if ($user && $user->email_verified_at) {
            return $next($request);
        }

         return redirect()->route('home')->with('notEmailVerified', 'Complete your email-verification!');
    }
}
