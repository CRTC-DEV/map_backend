<?php

namespace App\Http\Livewire\Web\TopMenu;

use App\Models\Web\TopMenu;
use Livewire\Component;

class TopMenuLive extends Component
{
    
    public $topmenu;

    public function mount(){

        $obj_topmenu= new TopMenu();
        $this->topmenu = $obj_topmenu->getAllTopMenu();
    }

    public function render()
    {
        return view('livewire.web.topmenu.topmenu_list');
    }
}
