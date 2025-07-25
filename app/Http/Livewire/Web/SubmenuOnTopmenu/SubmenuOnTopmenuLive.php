<?php

namespace App\Http\Livewire\Web\SubmenuOnTopmenu;

use App\Models\Web\SubmenuOnTopmenu;
use Livewire\Component;

class SubmenuOnTopmenuLive extends Component
{

    public $submenu_on_topmenu;
    public $item_title;
    public function mount(){
        // $obj_item = new ItemDescription();
        $obj_submenu_on_topmenus= new SubmenuOnTopmenu();
        $this->submenu_on_topmenu = $obj_submenu_on_topmenus->getAllSubmenuOnTopmenu();
        // dd($this->submenu_on_topmenu);
        //$this->submenu_on_topmenu = $obj_submenu_on_topmenus->getAllSubmenuOnTopmenuById(1);
        //dd($this->submenu_on_topmenu);
        // $this->submenu_on_topmenu = $obj_submenu_on_topmenus->getAllSubmenuOnTopmenuById(1);
        // dd($this->submenu_on_topmenu);
    }

    public function render()
    {
        return view('livewire.web.submenu-on-topmenu.submenu_on_topmenu_list');
    }
}
