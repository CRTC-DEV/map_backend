<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Exception;

class UserActivityLogger
{
    public static function log($action, $description = '', $data = [])
    {
        try {
            $user = null;
            $userRole = 'guest';
            $userName = 'Unknown';
            $userEmail = 'N/A';

            // Xác định user và role hiện tại
            if (Auth::guard('admin')->check()) {
                $user = Auth::guard('admin')->user();
                // Đảm bảo role là string, không phải object
                $userRole = is_string($user->role ?? null) ? $user->role : 'admin';
                $userName = $user->name ?? $user->email;
                $userEmail = $user->email;
            } elseif (Auth::guard('user')->check()) {
                $user = Auth::guard('user')->user();
                // Đảm bảo role là string, không phải object  
                $userRole = is_string($user->role ?? null) ? $user->role : 'user';
                $userName = $user->name ?? $user->email;
                $userEmail = $user->email;
            }

            $request = request();
            
            $logData = [
                'timestamp' => date('Y-m-d H:i:s'),
                'user_id' => $user ? $user->id : null,
                'user_name' => $userName,
                'user_email' => $userEmail,
                'user_role' => $userRole, // Role chính: admin, staff, kds, toc
                'action' => $action,
                'description' => $description,
                'ip_address' => $request->ip(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'data' => $data
            ];

            $logMessage = self::formatLogMessage($logData);
            
            // Tạo thư mục nếu chưa có
            $logDir = storage_path('logs');
            if (!is_dir($logDir)) {
                mkdir($logDir, 0755, true);
            }
            
            // Ghi vào file log theo role
            $logFile = "map_user_activity_{$userRole}.log";
            file_put_contents(
                storage_path("logs/{$logFile}"), 
                $logMessage . "\n", 
                FILE_APPEND | LOCK_EX
            );
            
            // Ghi thêm vào file tổng hợp
            file_put_contents(
                storage_path('logs/map_activity_all.log'), 
                $logMessage . "\n", 
                FILE_APPEND | LOCK_EX
            );
            
        } catch (Exception $e) {
            // Nếu có lỗi logging, không làm crash ứng dụng
            \Illuminate\Support\Facades\Log::error('UserActivityLogger failed: ' . $e->getMessage());
        }
    }

    private static function formatLogMessage($data)
    {
        return sprintf(
            '[%s] %s (%s) [%s] - %s: %s | IP: %s | %s %s | Data: %s',
            $data['timestamp'],
            $data['user_name'],
            $data['user_email'],
            strtoupper($data['user_role']),
            $data['action'],
            $data['description'],
            $data['ip_address'],
            $data['method'],
            $data['url'],
            json_encode($data['data'])
        );
    }

    // Các method cho Map components
    public static function logMapAction($action, $module, $description = '', $data = [])
    {
        self::log($action, "MAP-{$module}: {$description}", $data);
    }

    public static function logMapCreate($module, $model_id = null, $data = [])
    {
        self::logMapAction('CREATE', $module, "Created {$module}" . ($model_id ? " (ID: {$model_id})" : ''), $data);
    }

    public static function logMapUpdate($module, $model_id = null, $data = [])
    {
        self::logMapAction('UPDATE', $module, "Updated {$module}" . ($model_id ? " (ID: {$model_id})" : ''), $data);
    }

    public static function logMapDelete($module, $model_id = null, $data = [])
    {
        self::logMapAction('DELETE', $module, "Deleted {$module}" . ($model_id ? " (ID: {$model_id})" : ''), $data);
    }

    public static function logMapView($module, $page = '', $data = [])
    {
        self::logMapAction('VIEW', $module, "Viewed {$module} {$page}", $data);
    }
}
