<?php

namespace App\Http\Livewire\Map\GroupMainFunction;

use App\Traits\LogsMapActivity;

use Illuminate\Support\Facades\DB;
use App\Models\Map\GroupMainFunction;
use App\Models\Map\MainFunction;
use App\Models\Map\GroupFunction;
use Livewire\Component;

class GroupMainFunctionAddLive extends Component
{    
    
    use LogsMapActivity;
public $message;
    public $GroupMainFunction = [
        'Status' => ENABLE,
        'IsShowBothLocation' => 0,
    ];
    public $GroupFunction;
    public $MainFunction;
    public $available_groupfunctions;
    public $available_mainfunction;
    public $selectedGroupFunctions = []; // Các GroupFunctions được chọn
    public $selectedMainFunction = []; // Các MainFunctions được chọn


    public function rules()
    {
        $rules = [];        // Quy tắc luôn áp dụng cho GroupMainFunction
        $rules = array_merge($rules, [
            'GroupMainFunction.GroupFunctionId'=> 'required|integer',
            'GroupMainFunction.MainFunctionId'=> 'required|integer',
            'GroupMainFunction.Status' => 'required|numeric',
            'GroupMainFunction.IsShowBothLocation' => 'required|numeric',
          
        ]);

        return $rules;
    }

    public function messages()
    {
        return [];
    }

    public function mount()
    {
        $this->logMapPageView('Group Main Function Add Page');

        $this->available_mainfunction = (new MainFunction())->getAllFunction();
        $this->available_groupfunctions = (new GroupFunction())->getAllGroupFunctions();

    }

    public function render()
    {

        return view('livewire.map.group-mainfunction.group_mainfunction_add');
    }


    public function save()
    {
        $this->logMapAttempt('SAVE', 'Group Main Function Add');


        $this->validate();
        DB::beginTransaction();

        try {
             GroupMainFunction::create([
                'GroupFunctionId' => $this->GroupMainFunction['GroupFunctionId'],
                'MainFunctionId' => $this->GroupMainFunction['MainFunctionId'],
                // 'IconUrl' => $this->GroupMainFunction['IconUrl'],
                'Status' => $this->GroupMainFunction['Status'],
                'IsShowBothLocation' => $this->GroupMainFunction['IsShowBothLocation'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
            ]);
            DB::commit();

            return redirect()->route('group-mainfunction')->with(['message' => __('Insert Successful'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

    public function opensavelist()
    {
        $this->emit('openListGroupMainFunction');
    }

    public function insertlist()
    {
        if (empty($this->selectedGroupFunctions) || empty($this->selectedMainFunction)) {
            session()->flash('message', 'Please select at least one GroupFunction and one MainFunction.');
            session()->flash('status', 'warning');
            return;
        }
        // dd( $this->GroupMainFunction['orderIndex']);
        DB::beginTransaction();

        try {
            $skippedEntries = []; // Lưu trữ danh sách các cặp bị bỏ qua

            // Duyệt qua tất cả các kết hợp của GroupFunctionId và MainFunctionId
            foreach ($this->selectedGroupFunctions as $groupfunctionId) {
                foreach ($this->selectedMainFunction as $mainFuntionId) {
                    // Kiểm tra nếu cặp này đã tồn tại
                    $exists = GroupMainFunction::where('GroupFunctionId', $groupfunctionId)
                        ->where('MainFunctionId', $mainFuntionId)
                        ->exists();

                    if ($exists) {
                        // Thêm vào danh sách bỏ qua
                        $skippedEntries[] = "GroupFunctionId: $groupfunctionId, MainFunctionId: $mainFuntionId";
                        continue; // Bỏ qua nếu tồn tại
                    }
                    // dd($this->GroupMainFunction);
                    // Thêm mới nếu chưa tồn tại
                    GroupMainFunction::create([
                        'GroupFunctionId' => $groupfunctionId,
                        'MainFunctionId' => $mainFuntionId,
                        'Status' => $this->GroupMainFunction['Status'], // Default to 1 if not set
                        'CreatedDate' => now(),
                        'ModifiDate' => now(),
                        'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
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

            return redirect()->route('group-mainfunction');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}
