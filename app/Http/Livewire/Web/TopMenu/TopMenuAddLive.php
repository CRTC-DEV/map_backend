<?php
namespace App\Http\Livewire\Web\TopMenu;

use Illuminate\Support\Facades\DB;
use App\Models\ItemTitle;
use App\Models\Web\TopMenu;
use Livewire\Component;
use Livewire\WithFileUploads;

class TopMenuAddLive extends Component
{
    use WithFileUploads;
    public $message;
    public $TopMenu=['Status' => 2];
    public $Screen;
    public $item_title;

    public function rules()
    {
        return [
            
           // TopMenu validation rules
           'TopMenu.titleId' => 'required|numeric',
           'TopMenu.Status' => 'required|numeric',
           'TopMenu.OrderIndex' => '',

        ];
    }

    public function messages()
    {
        return [
            
        ];
    }

    public function mount()
    {

    }

    public function render()
    {
        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getItemsWithType(TOPMENU);//1 TopMenu
        //dd($this->item_title);

        return view('livewire.web.topmenu.topmenu_add');
    }


    public function save()
    {
        $this->validate();
        DB::beginTransaction();

        try {
            // Create TopMenu
            $topmenu = TopMenu::create([
                'TitleId' => $this->TopMenu['titleId'],
                'Status' => $this->TopMenu['Status'],
                'OrderIndex' => $this->TopMenu['OrderIndex'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
                'Rank' => 1,
            ]);

            DB::commit();

            return redirect()->route('admin.topmenu')->with(['message' => __('Insert Successfull'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

}
