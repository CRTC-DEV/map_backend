<?php

namespace App\Http\Livewire\Web\SubMenu;

use App\Models\Web\SubMenu;
use App\Models\ItemTitle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubMenuDetailLive extends Component
{
    use WithFileUploads;

    public $message;
    public $submenu_id;
    public $SubMenu;
    public $item_title;

    public function rules()
    {
        return [
            // SubMenu validation rules
            'SubMenu.TitleId' => 'required|numeric',
            'SubMenu.Status' => 'required|numeric',
            'SubMenu.OrderIndex' => '',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {

        $this->submenu_id = $id;
        $this->SubMenu = SubMenu::findOrFail($this->submenu_id)->toArray();
    }

    public function render()
    {
        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getItemsWithType(SUBMENU);//submenu

        return view('livewire.web.submenu.submenu_edit');
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            // Update SubMenu
            $submenu = SubMenu::findOrFail($this->submenu_id);
            $submenu->update([
                'TitleId' => $this->SubMenu['TitleId'],
                'Status' => (int) $this->SubMenu['Status'],
                'OrderIndex' => $this->SubMenu['OrderIndex'],
                'ModifiDate' => now(),
            ]);

            DB::commit();

            return redirect()->route('admin.submenu')->with(['message' => __('Update Successful'), 'status' => 'success']);
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
            // Delete SubMenu
            SubMenu::where('Id', $this->submenu_id)
                ->update(['Status' => 3,'ModifiDate' => now()]);

            DB::commit();

            return redirect()->route('admin.submenu')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}