<?php

namespace App\Http\Livewire\Map;

use App\Models\ItemTitle;
use App\Models\Map\MapItem;
use Livewire\Component;

class Dashboard extends Component
{
    
    public function render()
    {
        return view('livewire.map.dashboard');
    }
}
