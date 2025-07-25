<?php

namespace App\Http\Livewire\Map\DeviceTouchScreen;
use App\Models\Map\DeviceTouchScreen;
use App\Models\Map\T2Location;
use Livewire\Component;

class DeviceTouchScreenDetailLive extends Component
{

    public $message;
    public $t2location;
    public $device_touch_screen;
    public $device_touch_screen_id;
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

    public function mount($id)
    {
        $this->device_touch_screen_id = $id;
        $obj_device_touch_screen = new DeviceTouchScreen();
        $this->device_touch_screen = $obj_device_touch_screen->getDeviceTouchScreenById($id);
        // dd($this->device_touch_screen);
    }

    public function render()
    {
        $obj_t2location = new T2Location();
        $this->t2location = $obj_t2location->getAllT2Location();
        return view('livewire.map.device-touch-screen.device_touch_screen_edit');
    }

    public function save(){

        $this->validate();
        // dd($this->device_touch_screen);
        $obj_device_touch_screen = new DeviceTouchScreen();
        $obj_device_touch_screen->updateDeviceTouchScreen($this->device_touch_screen, $this->device_touch_screen_id);

        // $this->device_touch_screen->save();
        
        return redirect()->route('device-touch-screen')->with(['message' => __('be_msg.add_complete'), 'status' => 'success']);

    }

    public function delete()
    {   
        $this->device_touch_screen->Status = DELETED_FLG;
        $obj_device_touch_screen = new DeviceTouchScreen();
        $obj_device_touch_screen->deleteDeviceTouchScreenById(
           $this->device_touch_screen_id);
        
        return redirect()->route('device-touch-screen')->with(['message' => __('be_msg.delete_success'), 'status' => 'success']);
    }
}
