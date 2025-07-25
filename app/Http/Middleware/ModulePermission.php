<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModulePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $module
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        // $user = auth()->guard('admin')->user();
        $user = auth()->guard('user')->user();

        // dd($user);
        $userRole = $user->role;

        // Nếu role là một object (model relationship), lấy tên của role
        if (is_object($userRole)) {
            $userRole = $userRole->name ?? 'guest';
        }

        // Admin has access to everything
        if ($userRole === 'admin') {
            return $next($request);
        }

        // For other roles, check if they have permission to the module
        $allowedRoles = config("role_permissions.modules.{$module}", []);
        
        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }
        
        // Check if role has access to all modules
        $rolePermissions = config("role_permissions.roles.{$userRole}", []);
        if (in_array('all', $rolePermissions) || in_array($module, $rolePermissions)) {
            return $next($request);
        }

        // If no permission, abort with 403 Forbidden
        abort(403, 'Unauthorized action.');
    }
}
