<?php

namespace App\Http\Livewire\Web\Admin;

use App\Models\Admin;
use Livewire\Component;

class WebAdminManagement extends Component
{
    public $admins;
    public function mount(){
        // $obj_item = new ItemTitle();
        $obj_user= new Admin();
        $this->admins = $obj_user->getAllAdmin();
        // dd($this->item_title);
    }
    public function render()
    {   
        return view('livewire.web.admin.admin_list');
    }
}
