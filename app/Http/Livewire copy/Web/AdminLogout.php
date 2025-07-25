<?php

namespace App\Http\Livewire\Web;

use Livewire\Component;

class AdminLogout extends Component
{

    public function adminlogout() {

        if(auth()->guard('admin')->check()) {

            auth()->guard('admin')->logout();

            return redirect()->route('admin.login');

        }
    }
    public function render()
    {
        return view('livewire.web.admin_logout');
    }
}
