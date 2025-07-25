<?php

namespace App\Http\Livewire\Map\AdminManagement;

use App\Traits\LogsMapActivity;

use App\Models\User;
use Livewire\Component;

class AdminManagement extends Component
{
    
    use LogsMapActivity;
public $users;
    public function mount(){
        $this->logMapPageView('Admin Management Page');

        // $obj_item = new ItemTitle();
        $obj_user= new User();
        $this->users = $obj_user->getAllUser();
        // dd($this->item_title);
    }
    public function render()
    {   
        return view('livewire.map.admin-management.admin_management_list');
    }
}
