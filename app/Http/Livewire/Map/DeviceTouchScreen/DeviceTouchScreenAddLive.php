<?php

namespace App\Http\Livewire\Map\DeviceTouchScreen;

use App\Traits\LogsMapActivity;
use App\Models\Map\DeviceTouchScreen;
use App\Models\Map\T2Location;
use Livewire\Component;

class DeviceTouchScreenAddLive extends Component
{

    
    use LogsMapActivity;
public $message;
    public $device_touch_screen = ['Status' => 2];
    public $t2location;

    public function rules()
    {
        return [
           
            'device_touch_screen.DeviceCode' => 'required|string',
            'device_touch_screen.DeviceSerial' => 'required|string',   
            'device_touch_screen.T2LocationId' => 'required|numeric',       
            'device_touch_screen.Longitudes' => 'required|numeric',       
            'device_touch_screen.Latitudes' => 'required|numeric',
            'device_touch_screen.Status' => 'required|numeric',
            'device_touch_screen.AreaSide'=> '',
            'device_touch_screen.Rotation'=> '',
            'device_touch_screen.Description' => '',
            'device_touch_screen.Ip' => ''
           
        ];
    }

    public function messages()
    {
        return [
            // 'device_touch_screen.CadId.required' => __('zzz'),
            // 'device_touch_screen.CadId.numeric' => __('zzz'),
        ];
    }

    public function mount()
    {
        $this->logMapPageView('Device Touch Screen Add Page');


    }

    public function render()
    {
        $obj_t2location = new T2Location();
        $this->t2location = $obj_t2location->getAllT2Location();
       
        return view('livewire.map.device-touch-screen.device_touch_screen_add');
    }

    public function save(){
        $this->logMapAttempt('SAVE', 'Device Touch Screen Add');

        
        $this->validate();
        //dd('save');
        $obj_device_touch_screen = new DeviceTouchScreen();
        $obj_device_touch_screen->insertDeviceTouchScreen($this->device_touch_screen);

        return redirect()->route('device-touch-screen')->with(['message' => __('be_msg.add_complete'), 'status' => 'success']);

    }
}
