<?php

namespace App\Http\Livewire\Web\ConnectBusinesses;

use App\Models\Web\ConnectBusinesses;
use Livewire\Component;

class ConnectBusinessesLive extends Component
{
    public $connect_businesses;
    public $item_title;
    public function mount(){

        $admin = auth()->guard('admin')->user();
        $obj_connect_businesses= new ConnectBusinesses();
        if($admin->role->name == 'admin'|| $admin->email == 'son.pham@camranh.aero'|| $admin->email == 'son.nn@camranh.aero'|| $admin->email == 'test@test.com'){
            $this->connect_businesses = $obj_connect_businesses->getAllConnectBusinesses();
        }else{
            $this->connect_businesses = $obj_connect_businesses->getConnectBusinessesByUserId($admin->id);
        }
    }

    public function render()
    {
        return view('livewire.web.connect-businesses.connect_businesses_list');
    }
}
