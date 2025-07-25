<?php

namespace App\Http\Livewire\Map;

use Livewire\Component;

class CollapseMenu extends Component
{

    public $isCollapsed = true; // Trạng thái mặc định là đóng (collapsed)
    public function mount()
    {

    }

    public function render()
    {
        // Trả về view phù hợp theo vai trò người dùng
        if (auth()->guard('user')->check()) {
            $role = auth()->guard('user')->user()->role->name;

            switch ($role) {
                case 'admin':
                    return view('livewire.map.menu.menu-admin'); // Menu dành cho Admin
                case 'staff':
                    return view('livewire.map.menu.menu-staff'); // Menu dành cho Staff
                case 'author':
                    return view('livewire.map.menu.menu-author'); // Menu dành cho Staff
                default:
                    return view('livewire.map.menu.menu-author'); // Menu mặc định
            }
        }
    }
}
