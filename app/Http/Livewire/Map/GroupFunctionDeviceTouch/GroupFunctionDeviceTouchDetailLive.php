<?php

namespace App\Http\Livewire\Map\GroupFunctionDeviceTouch;

use App\Models\Map\GroupFunctionDeviceTouch;
use App\Models\Map\DeviceTouchScreen;
use App\Models\Map\GroupFunction;
use App\Models\ItemTitle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Map\T2Location;

class GroupFunctionDeviceTouchDetailLive extends Component
{
    use WithFileUploads;

    public $message;
    public $groupfunction_id;
    public $device_touch_screens_id;
    public $GroupFunctionDeviceTouch;
    public $GroupFunction = [];
    public $DeviceTouchScreen = [];
    public $available_groupfunctions;
    public $available_deviceTouchScreens;

    public function rules()
    {
        return [

            'GroupFunctionDeviceTouch.GroupFunctionId'=> 'required|integer',
            'GroupFunctionDeviceTouch.DeviceTouchScreenId'=> 'required|integer',
            'GroupFunctionDeviceTouch.Status' => 'required|numeric',
            'GroupFunctionDeviceTouch.OrderIndex' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {
        [$this->groupfunction_id, $this->device_touch_screens_id] = explode(",", $id);

        $this->GroupFunctionDeviceTouch = GroupFunctionDeviceTouch::where('GroupFunctionId', $this->groupfunction_id)
            ->where('DeviceTouchScreenId', $this->device_touch_screens_id)
            ->firstOrFail()
            ->toArray();


        $this->available_deviceTouchScreens = (new DeviceTouchScreen())->getAllDeviceTouchScreens();
        $this->available_groupfunctions = (new GroupFunction())->getAllGroupFunctions();
    }

    public function render()
    {

        return view('livewire.map.groupfunction-devicetouch.groupfunction_device_touch_edit');
    }

    public function save()
    {
        $this->validate();
    
        DB::beginTransaction();
    
        try {
            // Tìm bản ghi cụ thể dựa trên GroupFunctionId và DeviceTouchScreenId
            $affectedRows = DB::table('GroupFunctionDeviceTouch')
                ->where('GroupFunctionId', $this->groupfunction_id)
                ->where('DeviceTouchScreenId', $this->device_touch_screens_id)
                ->update([
                    'DeviceTouchScreenId' => $this->GroupFunctionDeviceTouch['DeviceTouchScreenId'],
                    'GroupFunctionId' => $this->GroupFunctionDeviceTouch['GroupFunctionId'],
                    'Status' => $this->GroupFunctionDeviceTouch['Status'],
                    'OrderIndex' => $this->GroupFunctionDeviceTouch['OrderIndex'],
                    'ModifiDate' => now(),
                ]);
    
            if ($affectedRows === 0) {
                throw new \Exception('No record was updated. Please check your inputs.');
            }
    
            DB::commit();
    
            return redirect()->route('groupfunction-devicetouch')->with([
                'message' => __('Update Successful'),
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

    public function delete()
    {
        DB::beginTransaction();

        try {
            // Delete GroupFunctionDeviceTouch
            GroupFunctionDeviceTouch::where('GroupFunctionId', $this->groupfunction_id)
                ->where('DeviceTouchScreenId', $this->device_touch_screens_id)
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