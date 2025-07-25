<?php
namespace App\Http\Livewire\Map\GroupFunction;

use App\Traits\LogsMapActivity;

use App\Models\Map\ItemType;
use Illuminate\Support\Facades\DB;
use App\Models\ItemTitle;
use App\Models\Map\GroupFunction;
use Livewire\Component;
use Livewire\WithFileUploads;

class GroupFunctionAddLive extends Component
{
    use WithFileUploads, LogsMapActivity;
    public $message;
    public $GroupFunction=['Status' => ENABLE];
    public $Screen;
    public $item_title;
    public $location;
    public $item_type;
    public $title_text;
    public $selectedGroupFunctions=[];

    public function rules()
    {
        return [
            
           'GroupFunction.titleId' => 'required|numeric',
           'GroupFunction.IconUrl' => 'required|string',
           'GroupFunction.Status' => 'required|numeric',

        ];
    }

    public function messages()
    {
        return [
            
        ];
    }

    public function mount()
    {
        $this->logMapPageView('Group Function Add Page');

        // dd($this->title_text);
    }

    public function render()
    {
        $obj_map_item = new ItemTitle();
        $this->item_title = $obj_map_item->getItemsWithType(GROUP_FUNCTION);//2 Group Function

        $obj_item_type = new ItemType();
        $this->item_type = $obj_item_type->getAllItemTypes();
        // dd($this->item_title);

        return view('livewire.map.group-function.group_function_add');
    }


    public function save()
    {
        $this->logMapAttempt('SAVE', 'Group Function Add');

        $this->validate();

        DB::beginTransaction();

        try {
            // Create GroupFunction
            $GroupFunction = GroupFunction::create([
                'TitleId' => $this->GroupFunction['titleId'],
                'Status' => $this->GroupFunction['Status'],
                'IconUrl' => $this->GroupFunction['IconUrl'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
                'Rank' => 1,
            ]);

            DB::commit();

            return redirect()->route('groupfunction')->with(['message' => __('Insert Successfull'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

    public function opensavelist()
    {
        $this->emit('openListGroupFunction');
    }

    public function insertlist()
    {
        if (empty($this->selectedGroupFunctions)) {
            session()->flash('message', 'Please select at least one GroupFunction');
            session()->flash('status', 'warning');
            return;
        }
        // dd( $this->GroupMainFunction['orderIndex']);
        DB::beginTransaction();

        try {
            $skippedEntries = []; // Lưu trữ danh sách các cặp bị bỏ qua

            // Duyệt qua tất cả các kết hợp của GroupFunctionId và MainFunctionId
            foreach ($this->selectedGroupFunctions as $title_id) {
                
                    // Kiểm tra nếu cặp này đã tồn tại
                    $exists = GroupFunction::where('TitleId', $title_id)
                        ->exists();

                    if ($exists) {
                        // Thêm vào danh sách bỏ qua
                        $skippedEntries[] = "TitleId: $title_id";
                        continue; // Bỏ qua nếu tồn tại
                    }
                    // dd($this->GroupMainFunction);
                    // Thêm mới nếu chưa tồn tại
                    GroupFunction::create([
                        'TitleId' => $title_id,
                        'IconUrl' => $this->GroupFunction['IconUrl'],
                        'Status' => $this->GroupFunction['Status'], // Default to 1 if not set
                        'CreatedDate' => now(),
                        'ModifiDate' => now(),
                        'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
                    ]);
                
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

            return redirect()->route('groupfunction');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}
