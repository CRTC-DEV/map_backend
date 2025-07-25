<?php

namespace App\Http\Livewire\Web\SubMenu;

use App\Models\Web\SubMenu;
use Livewire\Component;

class SubMenuLive extends Component
{
    
    public $submenu;
    public $item_title;
    public function mount(){

        $obj_submenu= new SubMenu();
        $this->submenu = $obj_submenu->getAllSubMenu();
    }

    public function render()
    {
        return view('livewire.web.submenu.submenu_list');
    }
}
