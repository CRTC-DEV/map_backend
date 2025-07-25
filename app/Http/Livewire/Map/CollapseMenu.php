<?php

namespace App\Http\Livewire\Map;

use Livewire\Component;
use Illuminate\Support\Facades\Config;

class CollapseMenu extends Component
{
    public $isCollapsed = true; // Trạng thái mặc định là đóng (collapsed)
    public $menuItems = []; // Danh sách các menu items sẽ hiển thị
    public $rolePermissions = []; // Quyền truy cập của người dùng
    public $userRole = ''; // Vai trò người dùng
    
    public function mount()
    {
        // Lấy vai trò của người dùng hiện tại
        if (auth()->guard('user')->check()) {
            $user = auth()->guard('user')->user();
            $this->userRole = $user->role->name;
            
            // Lấy danh sách quyền truy cập từ config
            $this->rolePermissions = $this->getUserPermissions($this->userRole);
            
            // Khởi tạo menu items dựa trên quyền truy cập
            $this->menuItems = $this->buildMenuItems();
        }
    }
    
    /**
     * Lấy danh sách quyền truy cập của người dùng
     * @param string $role Vai trò người dùng
     * @return array Danh sách các module mà người dùng có quyền truy cập
     */
    private function getUserPermissions($role)
    {
        // Lấy quyền từ config
        $permissions = Config::get("role_permissions.roles.$role", []);
        
        // Nếu có quyền 'all', trả về tất cả các module
        if (in_array('all', $permissions)) {
            return array_keys(Config::get('role_permissions.modules', []));
        }
        
        return $permissions;
    }
    
    /**
     * Xây dựng danh sách các menu items dựa trên quyền truy cập
     * @return array Danh sách menu items
     */
    private function buildMenuItems()
    {
        $items = [];
        
        // Thêm menu Dashboard cho tất cả người dùng đã đăng nhập
        $items[] = [
            'title' => 'Dashboard',
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'route' => 'dashboard',
            'active' => request()->routeIs('dashboard')
        ];
        
        // ===== MAP & LOCATION SECTION =====
        
        // Menu Map Items
        if ($this->hasPermission('map-item')) {
            $items[] = [
                'title' => 'Map Items',
                'icon' => 'fas fa-fw fa-map-marker-alt',
                'route' => 'map-item',
                'active' => request()->routeIs('map-item*')
            ];
        }
        
        // Menu Item Title
        if ($this->hasPermission('item-title')) {
            $items[] = [
                'title' => 'Item Title',
                'icon' => 'fas fa-fw fa-heading',
                'route' => 'item-title',
                'active' => request()->routeIs('item-title*')
            ];
        }
        
        // Menu T2 Location
        if ($this->hasPermission('t2-location')) {
            $items[] = [
                'title' => 'T2 Location',
                'icon' => 'fas fa-fw fa-location-arrow',
                'route' => 't2-location',
                'active' => request()->routeIs('t2-location*')
            ];
        }
        
        // ===== ROUTE SECTION =====
        
        // Menu Route Map Item
        if ($this->hasPermission('route-map-item')) {
            $items[] = [
                'title' => 'Route Map Item',
                'icon' => 'fas fa-fw fa-route',
                'route' => 'route-map-item',
                'active' => request()->routeIs('route-map-item*')
            ];
        }
        
        // Menu Route Map Item Detail
        if ($this->hasPermission('route-map-item-detail')) {
            $items[] = [
                'title' => 'Route Map Item Detail',
                'icon' => 'fas fa-fw fa-route',
                'route' => 'route-map-item-detail',
                'active' => request()->routeIs('route-map-item-detail*')
            ];
        }
        
        // ===== GROUP SEARCH SECTION =====
        
        // Menu Group Search
        if ($this->hasPermission('group-search')) {
            $items[] = [
                'title' => 'Group Search',
                'icon' => 'fas fa-fw fa-search',
                'route' => 'group-search',
                'active' => request()->routeIs('group-search*')
            ];
        }
        
        // Menu Group Search Map Item
        if ($this->hasPermission('group-search-map-item')) {
            $items[] = [
                'title' => 'Group Search Map Item',
                'icon' => 'fas fa-fw fa-search-location',
                'route' => 'group-search-map-item',
                'active' => request()->routeIs('group-search-map-item*')
            ];
        }
        
        // ===== DEVICE & TOUCH SCREEN SECTION =====
        
        // Menu Device Touch Screen
        if ($this->hasPermission('device-touch-screen')) {
            $items[] = [
                'title' => 'Device Touch Screen',
                'icon' => 'fas fa-fw fa-tablet-alt',
                'route' => 'device-touch-screen',
                'active' => request()->routeIs('device-touch-screen*')
            ];
        }
        
        // ===== BANNER SECTION =====
        
        // Menu Banner Adv
        if ($this->hasPermission('banner-adv')) {
            $items[] = [
                'title' => 'Banner Advertisements',
                'icon' => 'fas fa-fw fa-ad',
                'route' => 'banner-adv',
                'active' => request()->routeIs('banner-adv*')
            ];
        }
        
        // Menu Banner Adv Device Touch
        if ($this->hasPermission('banner-adv-device-touch')) {
            $items[] = [
                'title' => 'Banner Adv Device Touch',
                'icon' => 'fas fa-fw fa-tablet',
                'route' => 'banner-adv-device-touch',
                'active' => request()->routeIs('banner-adv-device-touch*')
            ];
        }
        
        // ===== SIGNAGE SECTION =====
        
        // Menu Signage
        if ($this->hasPermission('signage')) {
            $items[] = [
                'title' => 'Signage',
                'icon' => 'fas fa-fw fa-sign',
                'route' => 'signage',
                'active' => request()->routeIs('signage*')
            ];
        }
        
        // Menu Signage Device Touch
        if ($this->hasPermission('signage-devicetouch')) {
            $items[] = [
                'title' => 'Signage Device Touch',
                'icon' => 'fas fa-fw fa-sign',
                'route' => 'signage-devicetouch',
                'active' => request()->routeIs('signage-devicetouch*')
            ];
        }
        
        // Menu Signage Map Item
        if ($this->hasPermission('signage-mapitem')) {
            $items[] = [
                'title' => 'Signage Map Item',
                'icon' => 'fas fa-fw fa-map-signs',
                'route' => 'signage-mapitem',
                'active' => request()->routeIs('signage-mapitem*')
            ];
        }
        
        // ===== FUNCTION SECTION =====
        
        // Menu Main Function
        if ($this->hasPermission('main-function')) {
            $items[] = [
                'title' => 'Main Function',
                'icon' => 'fas fa-fw fa-cogs',
                'route' => 'mainfunction',
                'active' => request()->routeIs('mainfunction*')
            ];
        }
        
        // Menu Group Main Function
        if ($this->hasPermission('group-mainfunction')) {
            $items[] = [
                'title' => 'Group Main Function',
                'icon' => 'fas fa-fw fa-object-group',
                'route' => 'group-mainfunction',
                'active' => request()->routeIs('group-mainfunction*')
            ];
        }
        
        // Menu Group Function
        if ($this->hasPermission('group-function')) {
            $items[] = [
                'title' => 'Group Function',
                'icon' => 'fas fa-fw fa-object-ungroup',
                'route' => 'groupfunction',
                'active' => request()->routeIs('groupfunction*')
            ];
        }
        
        // Menu Group Function Device Touch
        if ($this->hasPermission('group-function-device-touch')) {
            $items[] = [
                'title' => 'Group Function Device',
                'icon' => 'fas fa-fw fa-mobile-alt',
                'route' => 'groupfunction-devicetouch',
                'active' => request()->routeIs('groupfunction-devicetouch*')
            ];
        }
        
        // ===== CONTENT SECTION =====
        
        // Menu Text Content
        if ($this->hasPermission('text-content')) {
            $items[] = [
                'title' => 'Text Content',
                'icon' => 'fas fa-fw fa-file-alt',
                'route' => 'text-content',
                'active' => request()->routeIs('text-content*')
            ];
        }
        
        // Menu Item Type
        if ($this->hasPermission('item-type')) {
            $items[] = [
                'title' => 'Item Type',
                'icon' => 'fas fa-fw fa-list',
                'route' => 'item-type',
                'active' => request()->routeIs('item-type*')
            ];
        }
        
        // Menu Item Description
        if ($this->hasPermission('item-description')) {
            $items[] = [
                'title' => 'Item Description',
                'icon' => 'fas fa-fw fa-file-text',
                'route' => 'item-description',
                'active' => request()->routeIs('item-description*')
            ];
        }
        
        // ===== EVENT & FAQ SECTION =====
        
        // Menu Event
        if ($this->hasPermission('event')) {
            $items[] = [
                'title' => 'Events',
                'icon' => 'fas fa-fw fa-calendar-alt',
                'route' => 'event',
                'active' => request()->routeIs('event*')
            ];
        }
        
        // Menu FAQ
        if ($this->hasPermission('faq')) {
            $items[] = [
                'title' => 'FAQ',
                'icon' => 'fas fa-fw fa-question-circle',
                'route' => 'faq',
                'active' => request()->routeIs('faq*')
            ];
        }
        
        // Menu FAQ Type
        if ($this->hasPermission('faq-type')) {
            $items[] = [
                'title' => 'FAQ Type',
                'icon' => 'fas fa-fw fa-list-alt',
                'route' => 'faq-type',
                'active' => request()->routeIs('faq-type*')
            ];
        }
        
        // ===== CONTACT SECTION =====
        
        // Menu Contact Number
        if ($this->hasPermission('contact-number')) {
            $items[] = [
                'title' => 'Contact Numbers',
                'icon' => 'fas fa-fw fa-phone',
                'route' => 'contact-number',
                'active' => request()->routeIs('contact-number*')
            ];
        }
        
        // Menu Contact Number Type
        if ($this->hasPermission('contact-number-type')) {
            $items[] = [
                'title' => 'Contact Number Types',
                'icon' => 'fas fa-fw fa-list-ol',
                'route' => 'contact-number-type',
                'active' => request()->routeIs('contact-number-type*')
            ];
        }
        
        // ===== LANGUAGE SECTION =====
        
        // Menu Language
        if ($this->hasPermission('language')) {
            $items[] = [
                'title' => 'Languages',
                'icon' => 'fas fa-fw fa-language',
                'route' => 'languages',
                'active' => request()->routeIs('languages*')
            ];
        }
        
        // Menu Translation
        if ($this->hasPermission('translation')) {
            $items[] = [
                'title' => 'Translations',
                'icon' => 'fas fa-fw fa-globe',
                'route' => 'translations',
                'active' => request()->routeIs('translations*')
            ];
        }
        
        // ===== ADMIN SECTION =====
        
        // Menu Admin Management (chỉ dành cho admin)
        if ($this->hasPermission('admin-management')) {
            $items[] = [
                'title' => 'Admin Management',
                'icon' => 'fas fa-fw fa-user-shield',
                'route' => 'admin-management',
                'active' => request()->routeIs('admin-management*')
            ];
        }
        
        return $items;
    }
    
    /**
     * Kiểm tra xem người dùng có quyền truy cập vào module cụ thể hay không
     * @param string $module Tên module cần kiểm tra
     * @return bool True nếu có quyền, False nếu không
     */
    private function hasPermission($module)
    {
        return in_array($module, $this->rolePermissions);
    }

    public function render()
    {
        // Trả về view chung với danh sách menu items động
        return view('livewire.map.menu.dynamic-menu', [
            'menuItems' => $this->menuItems
        ]);
    }
}
