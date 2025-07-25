<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckFrontend
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
    public function handle(Request $request, Closure $next)
    {
        config(['livewire.layout' => 'frontend-layouts.app']);
        return $next($request);

    }
}
