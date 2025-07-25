<?php

namespace App\Http\Livewire\Web\SubmenuOnTopmenu;

use Illuminate\Support\Facades\DB;
use App\Models\Web\SubmenuOnTopmenu;
use App\Models\Web\SubMenu;
use App\Models\Web\TopMenu;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubmenuOnTopmenuAddLive extends Component
{
    use WithFileUploads;
    public $message;
    public $SubmenuOnTopmenu = ['Status' => 2];
    public $TopMenu;
    public $SubMenu;
    public $available_topmenu;
    public $available_submenu;
    public $selectedTopMenus = []; // Các TopMenus được chọn
    public $selectedDevices = []; // Các SubMenus được chọn


    public function rules()
    {
        $rules = [];

        // Quy tắc luôn áp dụng cho SubmenuOnTopmenu
        $rules = array_merge($rules, [
            'SubmenuOnTopmenu.TopMenuId'=> 'required|integer',
            'SubmenuOnTopmenu.SubMenuId'=> 'required|integer',
            'SubmenuOnTopmenu.Status' => 'required|numeric',
            'SubmenuOnTopmenu.OrderIndex' => 'required|numeric',
        ]);

        return $rules;
    }

    public function messages()
    {
        return [];
    }

    public function mount()
    {
        $this->available_submenu = (new SubMenu())->getAllSubMenu();
        $this->available_topmenu = (new TopMenu())->getAllTopMenu();

    }

    public function render()
    {

        return view('livewire.web.submenu-on-topmenu.submenu_on_topmenu_add');
    }


    public function save()
    {

        $this->validate();
        DB::beginTransaction();

        try {
           
            SubmenuOnTopmenu::create([
                'TopMenuId' => $this->SubmenuOnTopmenu['TopMenuId'],
                'SubMenuId' => $this->SubmenuOnTopmenu['SubMenuId'],
                'Status' => $this->SubmenuOnTopmenu['Status'],
                'OrderIndex' => $this->SubmenuOnTopmenu['OrderIndex'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
            ]);
            DB::commit();

            return redirect()->route('admin.submenuontopmenu')->with(['message' => __('Insert Successful'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

    // public function opensavelist()
    // {
    //     $this->emit('openListDeviceTouchTopMenu');
    // }

    public function insertlist()
    {
        if (empty($this->selectedTopMenus) || empty($this->selectedDevices)) {
            session()->flash('message', 'Please select at least one TopMenu and one SubMenu.');
            session()->flash('status', 'warning');
            return;
        }
        // dd( $this->SubmenuOnTopmenu['orderIndex']);
        DB::beginTransaction();

        try {
            $skippedEntries = []; // Lưu trữ danh sách các cặp bị bỏ qua

            // Duyệt qua tất cả các kết hợp của TopMenuId và SubMenuId
            foreach ($this->selectedTopMenus as $groupfunctionId) {
                foreach ($this->selectedDevices as $deviceId) {
                    // Kiểm tra nếu cặp này đã tồn tại
                    $exists = SubmenuOnTopmenu::where('TopMenuId', $groupfunctionId)
                        ->where('SubMenuId', $deviceId)
                        ->exists();

                    if ($exists) {
                        // Thêm vào danh sách bỏ qua
                        $skippedEntries[] = "TopMenuId: $groupfunctionId, SubMenuId: $deviceId";
                        continue; // Bỏ qua nếu tồn tại
                    }
                    // dd($this->SubmenuOnTopmenu);
                    // Thêm mới nếu chưa tồn tại
                    SubmenuOnTopmenu::create([
                        'TopMenuId' => $groupfunctionId,
                        'SubMenuId' => $deviceId,
                        'Status' => $this->SubmenuOnTopmenu['Status'], // Default to 1 if not set
                        'CreatedDate' => now(),
                        'ModifiDate' => now(),
                        'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null), // Replace with dynamic UserId if needed
                        'OrderIndex' => $this->SubmenuOnTopmenu['orderIndex'], // Default to 0 if not set
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

            return redirect()->route('admin.submenuontopmenu');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}
