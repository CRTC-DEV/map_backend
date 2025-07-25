<?php

namespace App\Http\Livewire\Map\DeviceTouchScreen;

use App\Traits\LogsMapActivity;

use App\Models\Map\DeviceTouchScreen;
use Livewire\Component;

class DeviceTouchScreenLive extends Component
{
    
    use LogsMapActivity;
public $device_touch_screen;
    public function mount(){
        $this->logMapPageView('Device Touch Screen Page');

        // $obj_item = new ItemTitle();
        $obj_device_touch_screens= new DeviceTouchScreen();
        $this->device_touch_screen = $obj_device_touch_screens->getAllDeviceTouchScreens();
        // dd($this->device_touch_screen);
    }
    public function render()
    {
        return view('livewire.map.device-touch-screen.device_touch_screen');
    }
}
