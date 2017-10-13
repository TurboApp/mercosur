<?php

namespace App\Http\Middleware;

use Closure;

class CheckPerfils
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
        $perfiles=array_slice(func_get_args(), 2);

          if (auth()->user()->hasPerfils($perfiles)) {
            return $next($request);
          }

        return redirect('/');
    }
}
