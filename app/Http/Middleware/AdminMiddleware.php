<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
      $User = $request->user();

      if ($User) {
        if ($User->tipe == '2') {
          return $next($request);
        }
      }
      return abort(404);
    }
}
