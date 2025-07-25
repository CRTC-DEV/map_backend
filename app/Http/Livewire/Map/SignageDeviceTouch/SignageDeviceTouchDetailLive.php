<?php

namespace App\Http\Livewire\Map\SignageDeviceTouch;

use App\Traits\LogsMapActivity;

use App\Models\Map\SignageDeviceTouch;
use App\Models\Map\DeviceTouchScreen;
use App\Models\Map\Signages;
use App\Models\ItemTitle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Map\T2Location;

class SignageDeviceTouchDetailLive extends Component
{
    use WithFileUploads, LogsMapActivity;

    public $message;
    public $signage_id;
    public $device_touch_screens_id;
    public $SignageDeviceTouch = ['Status' => 2];
    public $Signage = [];
    public $DeviceTouchScreen = [];
    public $map_title;
    public $location;

    public function rules()
    {
        return [
            // Signage validation rules
            'Signage.CadId' => 'required|string|max:255',
            'Signage.TitleId' => 'required|numeric',
            'Signage.Longitudes' => 'required|numeric',
            'Signage.Latitudes' => 'required|numeric',
            'Signage.Status' => 'required|numeric',
            'Signage.Description' => '',
            'Signage.IconUrl' => '',
            'Signage.MapUrl' => '',
            'Signage.BackgroundUrl' => '',

            // DeviceTouchScreen validation rules
            'DeviceTouchScreen.DeviceCode' => 'required|string|max:255',
            'DeviceTouchScreen.DeviceSerial' => 'required|string|max:255',
            'DeviceTouchScreen.T2LocationId' => 'nullable|integer',
            'DeviceTouchScreen.Status' => 'required|numeric',
            'DeviceTouchScreen.Longitudes' => 'required|numeric',
            'DeviceTouchScreen.Latitudes' => 'required|numeric',

            // SignageDeviceTouch validation rules
            'SignageDeviceTouch.Status' => 'required|numeric',
            'SignageDeviceTouch.OrderIndex' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {
        $this->logMapPageView('Signage Device Touch Detail Page');

        [$this->signage_id, $this->device_touch_screens_id] = explode(",", $id);

        

        $this->SignageDeviceTouch = SignageDeviceTouch::where('SignageId', $this->signage_id)
            ->where('DeviceTouchScreenId', $this->device_touch_screens_id)
            ->firstOrFail()
            ->toArray();
        
        $this->Signage = Signages::findOrFail($this->signage_id)->toArray();
        $this->DeviceTouchScreen = DeviceTouchScreen::findOrFail($this->device_touch_screens_id)->toArray();
    }

    public function render()
    {
        $obj_map_item = new ItemTitle();
        $this->map_title = $obj_map_item->getAllItems();

        $obj_T2_location = new T2Location();
        $this->location = $obj_T2_location->getAllT2Location();

        return view('livewire.map.signage-devicetouch.signage_device_touch_edit');
    }

    public function save()
    {
        $this->logMapAttempt('SAVE', 'Signage Device Touch Detail');

        $this->validate();
        // DB::listen(function ($query) {
        //     \Log::info($query->sql, $query->bindings);
        // });
        DB::beginTransaction();

        try {
            // Update Signage
            $signage = Signages::where('Id',$this->signage_id)->firstOrFail();
            $signage->update([
                'CadId' => $this->Signage['CadId'],
                'TitleId' => $this->Signage['TitleId'],
                'Longitudes' => $this->Signage['Longitudes'],
                'Latitudes' => $this->Signage['Latitudes'],
                'Description' => $this->Signage['Description'],
                'IconUrl' => $this->Signage['IconUrl'],
                'MapUrl' => $this->Signage['MapUrl'],
                'BackgroundUrl' => $this->Signage['BackgroundUrl'],
                'Status' => $this->Signage['Status'],
                'ModifiDate' => now(),
            ]);

            // Update DeviceTouchScreen
            $device = DeviceTouchScreen::where('Id', $this->device_touch_screens_id)->firstOrFail();
            $device->update([
                'DeviceCode' => $this->DeviceTouchScreen['DeviceCode'],
                'DeviceSerial' => $this->DeviceTouchScreen['DeviceSerial'],
                'T2LocationId' => $this->DeviceTouchScreen['T2LocationId'],
                'Longitudes' => $this->DeviceTouchScreen['Longitudes'],
                'Latitudes' => $this->DeviceTouchScreen['Latitudes'],
                'Status' => $this->DeviceTouchScreen['Status'],
                'ModifiDate' => now(),
            ]);

            // Update SignageDeviceTouch
            $signageDeviceTouch = DB::table('SignageDeviceTouch')
                ->where('SignageId', $this->signage_id)
                ->where('DeviceTouchScreenId', $this->device_touch_screens_id);

            $signageDeviceTouch->update([
                'Status' => $this->SignageDeviceTouch['Status'],
                'OrderIndex' => $this->SignageDeviceTouch['OrderIndex'],
                'ModifiDate' => now(),
            ]);

            DB::commit();

            return redirect()->route('signage-devicetouch')->with(['message' => __('Update Successful'), 'status' => 'success']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

    public function delete()
    {
        $this->logMapAttempt('DELETE', 'Signage Device Touch Detail');

        DB::beginTransaction();

        try {
            // Delete SignageDeviceTouch
            SignageDeviceTouch::where('SignageId', $this->signage_id)
                ->where('DeviceTouchScreenId', $this->device_touch_screens_id)
                ->delete();

            DB::commit();

            return redirect()->route('signage-devicetouch')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}