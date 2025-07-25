<?php
namespace App\Http\Livewire\Web\SubMenu;

use Illuminate\Support\Facades\DB;
use App\Models\ItemTitle;
use App\Models\Web\SubMenu;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubMenuAddLive extends Component
{
    use WithFileUploads;
    public $message;
    public $SubMenu=['Status' => 2];
    public $Screen;
    public $item_title;

    public function rules()
    {
        return [
            
           // SubMenu validation rules
           'SubMenu.titleId' => 'required|numeric',
           'SubMenu.Status' => 'required|numeric',
           'SubMenu.OrderIndex' => '',

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
        $this->item_title = $obj_item_title->getItemsWithType(SUBMENU);//1 SubMenu
        //dd($this->item_title);

        return view('livewire.web.submenu.submenu_add');
    }


    public function save()
    {
        $this->validate();
        DB::beginTransaction();

        try {
            // Create SubMenu
            $submenu = SubMenu::create([
                'TitleId' => $this->SubMenu['titleId'],
                'Status' => $this->SubMenu['Status'],
                'OrderIndex' => $this->SubMenu['OrderIndex'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
                'Rank' => 1,
            ]);

            DB::commit();

            return redirect()->route('admin.submenu')->with(['message' => __('Insert Successfull'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

}
