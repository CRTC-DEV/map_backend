<?php

namespace App\Http\Livewire\Map;

use App\Http\Livewire\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function logout() {
        if (auth()->guard('user')->check()){

            auth()->guard('user')->logout();

            return redirect('/');
        }
    }
    public function render()
    {
        return view('livewire.map.logout');
    }
}
