<?php

namespace App\Http\Livewire\Web\SubmenuOnTopmenu;

use App\Models\Web\SubmenuOnTopmenu;
use App\Models\Web\SubMenu;
use App\Models\Web\TopMenu;
use App\Models\ItemTitle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Map\T2Location;

class SubmenuOnTopmenuDetailLive extends Component
{
    use WithFileUploads;

    public $message;
    public $topmenu_id;
    public $submenu_id;
    public $SubmenuOnTopmenu;
    public $TopMenu = [];
    public $SubMenu = [];
    public $available_topmenu;
    public $available_submenu;

    public function rules()
    {
        return [

            'SubmenuOnTopmenu.TopMenuId'=> 'required|integer',
            'SubmenuOnTopmenu.SubMenuId'=> 'required|integer',
            'SubmenuOnTopmenu.Status' => 'required|numeric',
            'SubmenuOnTopmenu.OrderIndex' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {
        [$this->topmenu_id, $this->submenu_id] = explode(",", $id);

        $this->SubmenuOnTopmenu = SubmenuOnTopmenu::where('TopMenuId', $this->topmenu_id)
            ->where('SubMenuId', $this->submenu_id)
            ->firstOrFail()
            ->toArray();


        $this->available_submenu = (new SubMenu())->getAllSubMenu();
        $this->available_topmenu = (new TopMenu())->getAllTopMenu();
    }

    public function render()
    {

        return view('livewire.web.submenu-on-topmenu.submenu_on_topmenu_edit');
    }

    public function save()
    {
        $this->validate();
    
        DB::beginTransaction();
    
        try {
            // Tìm bản ghi cụ thể dựa trên TopMenuId và SubMenuId
            $affectedRows = DB::table('SubmenuOnTopmenu')
                ->where('TopMenuId', $this->topmenu_id)
                ->where('SubMenuId', $this->submenu_id)
                ->update([
                    'Status' => $this->SubmenuOnTopmenu['Status'],
                    'OrderIndex' => $this->SubmenuOnTopmenu['OrderIndex'],
                    'ModifiDate' => now(),
                ]);
    
            if ($affectedRows === 0) {
                throw new \Exception('No record was updated. Please check your inputs.');
            }
    
            DB::commit();
    
            return redirect()->route('admin.submenuontopmenu')->with([
                'message' => __('Update Successful'),
                'status' => 'success'
            ]);
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
            // Delete SubmenuOnTopmenu
            SubmenuOnTopmenu::where('TopMenuId', $this->topmenu_id)
                ->where('SubMenuId', $this->submenu_id)
                ->delete();

            DB::commit();

            return redirect()->route('admin.submenuontopmenu')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}