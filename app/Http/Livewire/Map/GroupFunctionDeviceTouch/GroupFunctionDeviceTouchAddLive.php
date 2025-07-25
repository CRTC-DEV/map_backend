<?php

namespace App\Http\Livewire\Map\GroupFunctionDeviceTouch;

use App\Traits\LogsMapActivity;

use Illuminate\Support\Facades\DB;
use App\Models\Map\GroupFunctionDeviceTouch;
use App\Models\Map\DeviceTouchScreen;
use App\Models\Map\GroupFunction;
use Livewire\Component;
use Livewire\WithFileUploads;

class GroupFunctionDeviceTouchAddLive extends Component
{
    use WithFileUploads, LogsMapActivity;
    public $message;
    public $GroupFunctionDeviceTouch = ['Status' => 2];
    public $GroupFunction;
    public $DeviceTouchScreen;
    public $available_groupfunctions;
    public $available_deviceTouchScreens;
    public $selectedGroupFunctions = []; // Các GroupFunctions được chọn
    public $selectedDevices = []; // Các DeviceTouchScreens được chọn


    public function rules()
    {
        $rules = [];

        // Quy tắc luôn áp dụng cho GroupFunctionDeviceTouch
        $rules = array_merge($rules, [
            'GroupFunctionDeviceTouch.GroupFunctionId'=> 'required|integer',
            'GroupFunctionDeviceTouch.DeviceTouchScreenId'=> 'required|integer',
            'GroupFunctionDeviceTouch.Status' => 'required|numeric',
            'GroupFunctionDeviceTouch.OrderIndex' => 'required|numeric',
        ]);

        return $rules;
    }

    public function messages()
    {
        return [];
    }

    public function mount()
    {
        $this->logMapPageView('Group Function Device Touch Add Page');

        $this->available_deviceTouchScreens = (new DeviceTouchScreen())->getAllDeviceTouchScreens();
        $this->available_groupfunctions = (new GroupFunction())->getAllGroupFunctions();

    }

    public function render()
    {

        return view('livewire.map.groupfunction-devicetouch.groupfunction_device_touch_add');
    }


    public function save()
    {
        $this->logMapAttempt('SAVE', 'Group Function Device Touch Add');


        $this->validate();
        DB::beginTransaction();

        try {
           
            GroupFunctionDeviceTouch::create([
                'GroupFunctionId' => $this->GroupFunctionDeviceTouch['GroupFunctionId'],
                'DeviceTouchScreenId' => $this->GroupFunctionDeviceTouch['DeviceTouchScreenId'],
                'Status' => $this->GroupFunctionDeviceTouch['Status'],
                'OrderIndex' => $this->GroupFunctionDeviceTouch['OrderIndex'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
            ]);
            DB::commit();

            return redirect()->route('groupfunction-devicetouch')->with(['message' => __('Insert Successful'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

    public function opensavelist()
    {
        $this->emit('openListDeviceTouchGroupFunction');
    }

    public function insertlist()
    {
        if (empty($this->selectedGroupFunctions) || empty($this->selectedDevices)) {
            session()->flash('message', 'Please select at least one GroupFunction and one DeviceTouchScreen.');
            session()->flash('status', 'warning');
            return;
        }
        // dd( $this->GroupFunctionDeviceTouch['orderIndex']);
        DB::beginTransaction();

        try {
            $skippedEntries = []; // Lưu trữ danh sách các cặp bị bỏ qua

            // Duyệt qua tất cả các kết hợp của GroupFunctionId và DeviceTouchScreenId
            foreach ($this->selectedGroupFunctions as $groupfunctionId) {
                foreach ($this->selectedDevices as $deviceId) {
                    // Kiểm tra nếu cặp này đã tồn tại
                    $exists = GroupFunctionDeviceTouch::where('GroupFunctionId', $groupfunctionId)
                        ->where('DeviceTouchScreenId', $deviceId)
                        ->exists();

                    if ($exists) {
                        // Thêm vào danh sách bỏ qua
                        $skippedEntries[] = "GroupFunctionId: $groupfunctionId, DeviceTouchScreenId: $deviceId";
                        continue; // Bỏ qua nếu tồn tại
                    }
                    // dd($this->GroupFunctionDeviceTouch);
                    // Thêm mới nếu chưa tồn tại
                    GroupFunctionDeviceTouch::create([
                        'GroupFunctionId' => $groupfunctionId,
                        'DeviceTouchScreenId' => $deviceId,
                        'Status' => $this->GroupFunctionDeviceTouch['Status'], // Default to 1 if not set
                        'CreatedDate' => now(),
                        'ModifiDate' => now(),
                        'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null), 
                        'OrderIndex' => $this->GroupFunctionDeviceTouch['orderIndex'], // Default to 0 if not set
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

            return redirect()->route('groupfunction-devicetouch');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}
