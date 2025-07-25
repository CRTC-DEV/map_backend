<?php

namespace App\Http\Livewire\Web;

use App\Models\ItemTitle;
use App\Models\Map\MapItem;
use Livewire\Component;

class AdminDashboard extends Component
{
    
    public function render()
    {
        return view('livewire.web.admin_dashboard');
    }
}
