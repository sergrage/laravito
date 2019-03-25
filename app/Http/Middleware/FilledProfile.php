<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class FilledProfile
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
        $user = Auth::user();

        if (!$user->hasFilledProfile()){
            return redirect()
                ->route('cabinet.profile.home')
                ->with('error', 'Please fill your profile');
        }
        return $next($request);
    }
}
