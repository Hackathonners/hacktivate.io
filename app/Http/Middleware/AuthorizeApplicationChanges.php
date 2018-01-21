<?php

namespace App\Http\Middleware;

use Closure;

class AuthorizeApplicationChanges
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (app('settings')->withinApplicationsPeriod()) {
            return $next($request);
        }

        return redirect()->route('home')
            ->with('error', trans('settings.applications_closed'));
    }
}
