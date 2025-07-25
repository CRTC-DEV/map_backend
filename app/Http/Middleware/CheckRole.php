<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $roles
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        $user = auth()->guard('user')->user() ?? auth()->guard('admin')->user();
        // Kiểm tra nếu không có người dùng
        // dd($user->role->name);
        if (!$user) {
            abort(403, 'Unauthorized - No user logged in.');
            return redirect()->back();
        }
        // Tách vai trò được phép thành một mảng
        $roleList = explode('|', $roles);
        // dd($user->role->name, $roleList,$roles);
        // Kiểm tra nếu vai trò của người dùng không nằm trong danh sách
        if (!in_array($user->role->name, $roleList)) {
            abort(403, 'Unauthorized - Role not allowed.');
            return redirect()->back();
        }

        return $next($request);
    }
}