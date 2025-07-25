<?php

namespace App\Http\Livewire\Map\SignageDeviceTouch;

use App\Models\Map\MapItem;
use Illuminate\Support\Facades\DB;
use App\Models\Map\SignageDeviceTouch;
use App\Models\Map\DeviceTouchScreen;
use App\Models\ItemTitle;
use App\Models\Map\Signages;
use App\Models\Map\T2Location;
use Livewire\Component;
use Livewire\WithFileUploads;

class SignageDeviceTouchAddLive extends Component
{
    use WithFileUploads;
    public $message;
    public $SignageDeviceTouch = ['Status' => 2];
    public $Signage;
    public $DeviceTouchScreen;
    public $map_title;
    public $location;
    public $available_signages;
    public $available_deviceTouchScreens;
    public $selectedSignages = []; // Các Signages được chọn
    public $selectedDevices = []; // Các DeviceTouchScreens được chọn
    public $isDeviceTouchScreenDisabled = false;
    public $isSignageDisabled = false;
    public $role_base;

    public function rules()
    {
        $rules = [];

        // Nếu Signage không bị vô hiệu hóa, thêm các quy tắc cho Signage
        if (!$this->isSignageDisabled) {
            $rules = array_merge($rules, [
                'Signage.cadId' => 'required|string|max:255',
                'Signage.titleId' => 'required|numeric',
                'Signage.longitudes' => 'required|numeric',
                'Signage.latitudes' => 'required|numeric',
                'Signage.Status' => 'required|numeric',
                'Signage.Description' => '',
                'Signage.IconUrl' => '',
                'Signage.MapUrl' => '',
                'Signage.BackgroundUrl' => '',
            ]);
        }

        // Nếu DeviceTouchScreen không bị vô hiệu hóa, thêm các quy tắc cho DeviceTouchScreen
        if (!$this->isDeviceTouchScreenDisabled) {
            $rules = array_merge($rules, [
                'DeviceTouchScreen.deviceCode' => 'required|string|max:255',
                'DeviceTouchScreen.deviceSerial' => 'required|string|max:255',
                'DeviceTouchScreen.locationId' => 'nullable|integer',
                'DeviceTouchScreen.deviceStatus' => 'required|numeric',
                'DeviceTouchScreen.longitudes' => 'required|numeric',
                'DeviceTouchScreen.latitudes' => 'required|numeric',
            ]);
        }

        // Quy tắc luôn áp dụng cho SignageDeviceTouch
        $rules = array_merge($rules, [
            'SignageDeviceTouch.Status' => 'required|numeric',
            'SignageDeviceTouch.orderIndex' => 'required|integer',
        ]);

        return $rules;
    }

    public function messages()
    {
        return [];
    }

    public function mount()
    {
        $this->available_deviceTouchScreens = (new DeviceTouchScreen())->getAllDeviceTouchScreens();
        $this->available_signages = (new Signages())->getAllSignages();
        
        $this->role_base = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
    }

    public function render()
    {
        $obj_map_item = new ItemTitle();
        $this->map_title = $obj_map_item->getAllItems();

        $obj_T2_location = new T2Location();
        $this->location = $obj_T2_location->getAllT2Location();

        return view('livewire.map.signage-devicetouch.signage_device_touch_add');
    }


    public function save()
    {

        $this->validate();
        DB::beginTransaction();

        try {
            // Create Signage
            $signage = null;
            if (!$this->isSignageDisabled) {
                $signage = Signages::create([
                    'CadId' => $this->Signage['cadId'],
                    'TitleId' => $this->Signage['titleId'],
                    'Longitudes' => $this->Signage['longitudes'],
                    'Latitudes' => $this->Signage['latitudes'],
                    'Description' => $this->Signage['Description'],
                    'IconUrl' => $this->Signage['IconUrl'],
                    'MapUrl' => $this->Signage['MapUrl'],
                    'BackgroundUrl' => $this->Signage['BackgroundUrl'],
                    'Status' => $this->Signage['Status'],
                    'CreatedDate' => now(),
                    'ModifiDate' => now(),
                    'UserId' => $this->role_base,
                    'Rank' => 1,
                ]);
            }

            // Create DeviceTouchScreen
            $device = null;
            if (!$this->isDeviceTouchScreenDisabled) {
                $device = DeviceTouchScreen::create([
                    'DeviceCode' => $this->DeviceTouchScreen['deviceCode'],
                    'DeviceSerial' => $this->DeviceTouchScreen['deviceSerial'],
                    'T2LocationId' => $this->DeviceTouchScreen['locationId'],
                    'Longitudes' => $this->DeviceTouchScreen['longitudes'],
                    'Latitudes' => $this->DeviceTouchScreen['latitudes'],
                    'Status' => $this->DeviceTouchScreen['deviceStatus'],
                    'CreatedDate' => now(),
                    'ModifiDate' => now(),
                    'UserId' => $this->role_base,
                ]);
            }

            // Link Signage and DeviceTouchScreen
            $signageId = $this->isSignageDisabled ? $this->selectedSignages : ($signage ? $signage->Id : null);
            $deviceId = $this->isDeviceTouchScreenDisabled ? $this->selectedDevices : ($device ? $device->Id : null);
            // dd($signageId , $deviceId,$this->isSignageDisabled,$signage);
            if ($signageId && $deviceId) {
                SignageDeviceTouch::create([
                    'SignageId' => $signageId,
                    'DeviceTouchScreenId' => $deviceId,
                    'Status' => $this->SignageDeviceTouch['Status'],
                    'CreatedDate' => now(),
                    'ModifiDate' => now(),
                    'UserId' => $this->role_base,
                    'OrderIndex' => $this->SignageDeviceTouch['orderIndex'],
                ]);
            } else {
                throw new \Exception('Invalid Signage or DeviceTouchScreen data.');
            }

            DB::commit();

            return redirect()->route('signage-devicetouch')->with(['message' => __('Insert Successful'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

    public function opensavelist()
    {
        $this->emit('openListDeviceTouchSignage');
    }

    public function insertlist()
    {
        if (empty($this->selectedSignages) || empty($this->selectedDevices)) {
            session()->flash('message', 'Please select at least one Signage and one DeviceTouchScreen.');
            session()->flash('status', 'warning');
            return;
        }
        // dd( $this->SignageDeviceTouch['orderIndex']);
        DB::beginTransaction();

        try {
            $skippedEntries = []; // Lưu trữ danh sách các cặp bị bỏ qua

            // Duyệt qua tất cả các kết hợp của SignageId và DeviceTouchScreenId
            foreach ($this->selectedSignages as $signageId) {
                foreach ($this->selectedDevices as $deviceId) {
                    // Kiểm tra nếu cặp này đã tồn tại
                    $exists = SignageDeviceTouch::where('SignageId', $signageId)
                        ->where('DeviceTouchScreenId', $deviceId)
                        ->exists();

                    if ($exists) {
                        // Thêm vào danh sách bỏ qua
                        $skippedEntries[] = "SignageId: $signageId, DeviceTouchScreenId: $deviceId";
                        continue; // Bỏ qua nếu tồn tại
                    }
                    // dd($this->SignageDeviceTouch);
                    // Thêm mới nếu chưa tồn tại
                    SignageDeviceTouch::create([
                        'SignageId' => $signageId,
                        'DeviceTouchScreenId' => $deviceId,
                        'Status' => $this->SignageDeviceTouch['Status'], // Default to 1 if not set
                        'CreatedDate' => now(),
                        'ModifiDate' => now(),
                        'UserId' => $this->role_base, // Replace with dynamic UserId if needed
                        'OrderIndex' => $this->SignageDeviceTouch['orderIndex'], // Default to 0 if not set
                    ]);
                }
            }

            DB::commit();

            // Xử lý thông báo
            if (!empty($skippedEntries)) {
                session()->flash(
                    'message',
                    'Insert Successful with some duplicates skipped: ' . implode('; ', $skippedEntries)
                );
                session()->flash('status', 'warning');
            } else {
                session()->flash('message', __('Insert Successful'));
                session()->flash('status', 'success');
            }

            return redirect()->route('signage-devicetouch');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}
