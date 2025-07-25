<?php
namespace App\Http\Livewire\Map\MainFunction;

use App\Traits\LogsMapActivity;

use App\Models\Map\ItemType;
use Illuminate\Support\Facades\DB;
use App\Models\ItemTitle;
use App\Models\Map\MainFunction;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Map\Signages;

class MainFunctionAddLive extends Component
{
    use WithFileUploads, LogsMapActivity;
    public $message;
    public $mainfunction=['Status' => ENABLE];    
    public $item_title;
    public $location;
    public $item_type;   
    public $available_mainfunction; 
    public $selectedMainFunction = []; // Các MainFunctions được chọn
    public $signages;
    public $selected_signagesId = [];
    
    public Function rules()
    {
        return [
            
           'mainfunction.titleId' => 'required|numeric',
           'mainfunction.Link' => '',
           'mainfunction.IconUrl' => 'required|string',
           'mainfunction.Status' => 'required|numeric',
           'mainfunction.selected_signagesId' => '',

        ];
    }

    public Function messages()
    {
        return [
            
        ];
    }

    public Function mount()
    {
        $this->available_mainfunction = (new MainFunction())->getAllFunction();
       
        // dd($this->signages);
    }

    public Function render()
    {
        $obj_1 = new ItemTitle();
        $this->item_title = $obj_1->getItemsWithType(MAINFUNCTION);//3 Group MainFunction
        //dd( $this->item_title);
        $obj_2 = new ItemType();
        $this->item_type = $obj_2->getAllItemTypes();
        // dd($this->item_title);
        $this->signages = (new Signages())->getAllSignages();

        return view('livewire.map.mainfunction.mainfunction_add');
    }

    public function opensavelist()
    {
        $this->emit('openListMainFunction');
    }

    public function insertlist()
    {
        if (empty($this->selectedMainFunction)) {
            session()->flash('message', 'Please select at least one GroupFunction and one MainFunction.');
            session()->flash('status', 'warning');
            return;
        }
        //dd( $this->selectedMainFunction);
        DB::beginTransaction();

        try {
            $skippedEntries = []; // Lưu trữ danh sách các cặp bị bỏ qua

            // Duyệt qua tất cả các kết hợp của GroupFunctionId và MainFunctionId
           
                foreach ($this->selectedMainFunction as $mainFuntionId) {
                    // Kiểm tra nếu cặp này đã tồn tại
                    $exists = MainFunction::where('Id', $mainFuntionId)                        
                        ->exists();

                    if ($exists) {
                        // Thêm vào danh sách bỏ qua
                        $skippedEntries[] = "Id: $mainFuntionId";
                        continue; // Bỏ qua nếu tồn tại
                    }
                    //dd($this->MainFunction);
                    // Thêm mới nếu chưa tồn tại
                    MainFunction::create([                        
                        'Id' => $mainFuntionId,
                        'TitleId' => $mainFuntionId,
                        'Status' => $this->mainfunction['Status'], // Default to 1 if not set
                        'IconUrl' => $this->mainfunction['IconUrl'],
                        'Link' => $this->mainfunction['Link'],
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

            return redirect()->route('mainfunction');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }


    public Function save()
    {
        $this->validate();
        // dd(json_encode($this->selected_signagesId));
        DB::beginTransaction();

        try {
            // Create MainFunction
            $mainfunction = MainFunction::create([
                'TitleId' => $this->mainfunction['titleId'],
                'Status' => $this->mainfunction['Status'],
                'IconUrl' => $this->mainfunction['IconUrl'],
                'Link' => $this->mainfunction['Link'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
                'Rank' => 1,
                'SignagesId' => json_encode($this->selected_signagesId),
            ]);

            DB::commit();

            return redirect()->route('mainfunction')->with(['message' => __('Insert Successfull'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }


}
