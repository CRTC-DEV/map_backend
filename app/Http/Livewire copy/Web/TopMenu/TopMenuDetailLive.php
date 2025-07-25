<?php

namespace App\Http\Livewire\Web\TopMenu;

use App\Models\Web\TopMenu;
use App\Models\Map\ItemType;
use App\Models\ItemTitle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class TopMenuDetailLive extends Component
{
    use WithFileUploads;

    public $message;
    public $topmenu_id;
    public $TopMenu;
    public $item_title;
    public $item_type;

    public function rules()
    {
        return [
            // TopMenu validation rules
            'TopMenu.TitleId' => 'required|numeric',
            'TopMenu.Status' => 'required|numeric',
            'TopMenu.OrderIndex' => '',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {

        $this->topmenu_id = $id;
        $this->TopMenu = TopMenu::findOrFail($this->topmenu_id)->toArray();
    }

    public function render()
    {
        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getItemsWithType(TOPMENU);//topmenu

        return view('livewire.web.topmenu.topmenu_edit');
    }

    public function save()
    {
        $this->validate();
        // dd($this->TopMenu);
        DB::beginTransaction();

        try {
            // Update TopMenu
            $topmenu = TopMenu::findOrFail($this->topmenu_id);
            $topmenu->update([
                'TitleId' => $this->TopMenu['TitleId'],
                'Status' => (int) $this->TopMenu['Status'],
                'OrderIndex' => $this->TopMenu['Description'],
                'ModifiDate' => now(),
            ]);

            DB::commit();

            return redirect()->route('admin.topmenu')->with(['message' => __('Update Successful'), 'status' => 'success']);
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
            // Delete TopMenu
            TopMenu::where('Id', $this->topmenu_id)
                ->update(['Status' => 3,'ModifiDate' => now()]);

            DB::commit();

            return redirect()->route('admin.topmenu')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}