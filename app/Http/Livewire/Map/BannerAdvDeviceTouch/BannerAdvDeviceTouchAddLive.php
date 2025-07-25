<?php
namespace App\Http\Livewire\Map\BannerAdvDeviceTouch;

use App\Traits\LogsMapActivity;

use App\Models\Map\BannerAdvDeviceTouch;
use App\Models\Map\BannerAdv;
use App\Models\Map\DeviceTouchScreen;

use Livewire\Component;

class BannerAdvDeviceTouchAddLive extends Component
{

    
    use LogsMapActivity;
public $message;
   
    //public $group_search;
    public $banner_adv_device_touch=['Status'=>'2'] ;
    public $banner_adv;
    public $device_touch;

    public function rules()
    {
        return [
            'banner_adv_device_touch.BannerAdvId' => 'required|numeric',         
            'banner_adv_device_touch.DeviceTouchScreenId' => 'required|numeric',
           'banner_adv_device_touch.Status' => 'required|numeric',           
          
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    public function mount()
    {
        $this->logMapPageView('Banner Adv Device Touch Add Page');

        
    }

    public function render()
    {
       //note don't add model current to this

        $obj_banner_adv = new BannerAdv();
        $this->banner_adv = $obj_banner_adv->getAllBannerAdv();

        $obj_device_touch = new DeviceTouchScreen();
        $this->device_touch = $obj_device_touch->getAllDeviceTouchScreens();
        return view('livewire.map.banner-adv-device-touch.banner_adv_device_touch_add');
    }

    public function save(){
        $this->logMapAttempt('SAVE', 'Banner Adv Device Touch Add');

        
        
        $this->validate();       
        $obj = new BannerAdvDeviceTouch();        
        $obj->insertItem($this->banner_adv_device_touch);
        return redirect()->route('banner-adv-device-touch')->with(['message' => __('be_msg.add_complete'), 'status' => 'success']);

    }
}
