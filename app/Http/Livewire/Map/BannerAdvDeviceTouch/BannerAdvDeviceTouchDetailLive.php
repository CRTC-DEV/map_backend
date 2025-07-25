<?php
namespace App\Http\Livewire\Map\BannerAdvDeviceTouch;

use App\Traits\LogsMapActivity;

use Illuminate\Support\Facades\DB;
use App\Models\Map\BannerAdvDeviceTouch;
use App\Models\Map\BannerAdv;
use App\Models\Map\DeviceTouchScreen;

use Livewire\Component;

class BannerAdvDeviceTouchDetailLive extends Component
{

    
    use LogsMapActivity;
public $message;
   
    //public $group_search;
    public $banner_adv_device_touch=['Status'=>'2'] ;
    public $banner_adv;
    public $banneradv_id;
    public $device_touch; 
    public $device_touch_id;

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

    public function mount($id)
    {
        $this->logMapPageView('Banner Adv Device Touch Detail Page');

        [$this->banneradv_id, $this->device_touch_id] = explode(",", $id);

        $obj= new BannerAdvDeviceTouch();
        $this->banner_adv_device_touch = $obj->getItemById( $this->banneradv_id, $this->device_touch_id);
        // $this->translationsStatus = $this->translations->Status;
        
    }

    public function render()
    {
       //note don't add model current to this

        $obj_banner_adv = new BannerAdv();
        $this->banner_adv = $obj_banner_adv->getAllBannerAdv();

        $obj_device_touch = new DeviceTouchScreen();
        $this->device_touch = $obj_device_touch->getAllDeviceTouchScreens();
        return view('livewire.map.banner-adv-device-touch.banner_adv_device_touch_edit');
    }

    public function save(){
        $this->logMapAttempt('SAVE', 'Banner Adv Device Touch Detail');

        
        
        $this->validate();       
        $obj = new BannerAdvDeviceTouch();    
        //dd($this->banner_adv_device_touch);    
        $obj->updateItem($this->banner_adv_device_touch,$this->banneradv_id,$this->device_touch_id);
        return redirect()->route('banner-adv-device-touch')->with(['message' => __('be_msg.add_complete'), 'status' => 'success']);

    }

    public function delete()
    {
        $this->logMapAttempt('DELETE', 'Banner Adv Device Touch Detail');

        DB::beginTransaction();

        try {
            // Delete GroupFunctionDeviceTouch
            BannerAdvDeviceTouch::where('BanneradvId', $this->banneradv_id)
                ->where('DeviceTouchScreenId', $this->device_touch_id)
                ->delete();

            DB::commit();

            return redirect()->route('groupfunction-devicetouch')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

    
}
