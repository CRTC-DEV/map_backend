<?php

namespace App\Traits;

trait LogsMapActivity
{
    public function logMapComponentAction($action, $model_name, $model_id = null, $data = [])
    {
        $component_name = class_basename(static::class);
        $module = $this->getModuleName($component_name);
        
        switch (strtolower($action)) {
            case 'create':
                map_log_create($module, $model_id, array_merge($data, ['component' => $component_name]));
                break;
            case 'update':
                map_log_update($module, $model_id, array_merge($data, ['component' => $component_name]));
                break;
            case 'delete':
                map_log_delete($module, $model_id, array_merge($data, ['component' => $component_name]));
                break;
            case 'view':
                map_log_view($module, $model_name, array_merge($data, ['component' => $component_name]));
                break;
            default:
                map_log_custom($action, $module, "Performed {$action} on {$model_name}", array_merge($data, ['component' => $component_name]));
        }
    }

    public function logMapAttempt($action, $model_name, $data = [])
    {
        $this->logMapComponentAction("ATTEMPT_{$action}", $model_name, null, $data);
    }

    public function logMapSuccess($action, $model_name, $model_id = null, $data = [])
    {
        $this->logMapComponentAction("{$action}_SUCCESS", $model_name, $model_id, $data);
    }

    public function logMapError($action, $model_name, $error, $data = [])
    {
        $this->logMapComponentAction("{$action}_ERROR", $model_name, null, array_merge($data, ['error' => $error]));
    }

    public function logMapPageView($page_name = null)
    {
        $component_name = class_basename(static::class);
        $module = $this->getModuleName($component_name);
        $page = $page_name ?: str_replace(['Live', 'Component'], '', $component_name);
        map_log_view($module, $page, ['component' => $component_name]);
    }

    private function getModuleName($component_name)
    {
        // Extract module name from component class name
        // EventAddLive -> Event
        // MapItemDetailLive -> MapItem
        $module = preg_replace('/(Add|Detail|Live)$/', '', $component_name);
        
        // Convert PascalCase to kebab-case
        $module = preg_replace('/([A-Z])/', '-$1', $module);
        $module = trim($module, '-');
        $module = strtolower($module);
        
        return $module;
    }
}
