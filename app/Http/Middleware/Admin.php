<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if(!\Auth::user()->is_admin && in_array(\Route::getCurrentRoute()->parameter('view'),config('admin')))
            return \Redirect::intended(\RouteUrls::control());

        return $next($request);
    }
}
