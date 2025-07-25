<?php

namespace App\Http\Livewire\Map\Signage;

use App\Models\Map\Signages;
use Livewire\Component;

class SignageLive extends Component
{
    
    public $signage;
    public $item_title;
    public function mount(){
        // $obj_item = new ItemDescription();
        $obj_signage_device_touchs= new Signages();
        $this->signage = $obj_signage_device_touchs->getAllSignages();
        // dd($this->signage);
    }

    public function render()
    {
        return view('livewire.map.signage.signage_list');
    }
}
