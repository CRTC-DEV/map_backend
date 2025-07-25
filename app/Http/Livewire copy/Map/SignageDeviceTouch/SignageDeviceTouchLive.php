<?php

namespace App\Http\Livewire\Map\SignageDeviceTouch;

use App\Models\Map\SignageDeviceTouch;
use Livewire\Component;

class SignageDeviceTouchLive extends Component
{
    public $item_type;
    public $signage_device_touch;
    public $item_title;
    public function mount(){
        // $obj_item = new ItemDescription();
        $obj_signage_device_touchs= new SignageDeviceTouch();
        $this->signage_device_touch = $obj_signage_device_touchs->getAllSignageDeviceTouch();
        // dd($this->signage_device_touch);
    }

    public function render()
    {
        return view('livewire.map.signage-devicetouch.signage_device_touch_list');
    }
}
