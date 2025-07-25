<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Modules\Permission\Permission;
use App\Models\Menu;
use Illuminate\Support\Facades\Session;
use App\Repositories\AdminRepositories;
use Illuminate\Http\Request;

class CheckAdmin
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
        config(['livewire.layout' => 'admin-layouts.app']);
        
        if (auth()->guard('admin')->user()) {
            return $next($request);
        } else {
            return redirect()->route("admin.login");
        }
    }
}
