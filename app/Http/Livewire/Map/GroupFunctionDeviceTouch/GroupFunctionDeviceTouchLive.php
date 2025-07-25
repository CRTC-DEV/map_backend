<?php

namespace App\Http\Livewire\Map\GroupFunctionDeviceTouch;

use App\Models\Map\GroupFunctionDeviceTouch;
use Livewire\Component;

class GroupFunctionDeviceTouchLive extends Component
{
    public $item_type;
    public $groupfunction_device_touch;
    public $item_title;
    public function mount(){
        // $obj_item = new ItemDescription();
        $obj_groupfunction_device_touchs= new GroupFunctionDeviceTouch();
        $this->groupfunction_device_touch = $obj_groupfunction_device_touchs->getAllGroupFunctionDeviceTouch();
        // dd($this->groupfunction_device_touch);
    }

    public function render()
    {
        return view('livewire.map.groupfunction-devicetouch.groupfunction_device_touch_list');
    }
}
