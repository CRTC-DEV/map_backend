<?php

namespace App\Http\Livewire\Map\BannerAdvDeviceTouch;

use App\Traits\LogsMapActivity;
use Livewire\Component;
use App\Models\Map\BannerAdvDeviceTouch;


class BannerAdvDeviceTouchLive extends Component
{
    
    use LogsMapActivity;
public $items;
    public function mount(){
        $this->logMapPageView('Banner Adv Device Touch Page');

        // $obj_item = new ItemTitle();
        $obj= new BannerAdvDeviceTouch();
        $this->items = $obj->getAllItems();
        // dd($this->items);
    }
    public function render()
    {   
        return view('livewire.map.banner-adv-device-touch.banner_adv_device_touch');
    }
}
