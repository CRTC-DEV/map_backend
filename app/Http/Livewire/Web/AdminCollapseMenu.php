<?php

namespace App\Http\Livewire\Web;

use Livewire\Component;

class AdminCollapseMenu extends Component
{

    public $isCollapsed = true; // Trạng thái mặc định là đóng (collapsed)
    public function mount()
    {

    }

    public function render()
    {
        // Trả về view phù hợp theo vai trò người dùng
        if (auth()->guard('admin')->check()) {
            $role = auth()->guard('admin')->user()->role->name;

            switch ($role) {
                case 'admin':
                    return view('livewire.web.sidebar-menu.menu-admin'); // Menu dành cho Admin
                case 'staff':
                    return view('livewire.web.sidebar-menu.menu-staff'); // Menu dành cho Staff
                case 'author':
                    return view('livewire.web.sidebar-menu.menu-author'); // Menu dành cho Staff
                default:
                    return view('livewire.web.sidebar-menu.menu-author'); // Menu mặc định
            }
        }
    }
}
