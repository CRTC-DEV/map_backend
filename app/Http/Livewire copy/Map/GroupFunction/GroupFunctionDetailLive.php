<?php

namespace App\Http\Livewire\Map\GroupFunction;

use App\Models\Map\GroupFunction;
use App\Models\Map\ItemType;
use App\Models\ItemTitle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class GroupFunctionDetailLive extends Component
{
    use WithFileUploads;

    public $message;
    public $GroupFunction_id;
    public $GroupFunction;
    public $item_title;
    public $item_type;

    public function rules()
    {
        return [
            // GroupFunction validation rules
            'GroupFunction.TitleId' => 'required|numeric',
            'GroupFunction.IconUrl' => 'required|string',
            'GroupFunction.Status' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {

        $this->GroupFunction_id = $id;
        $this->GroupFunction = GroupFunction::findOrFail($this->GroupFunction_id)->toArray();
    }

    public function render()
    {
        $obj_map_item = new ItemTitle();
        $this->item_title = $obj_map_item->getItemsWithType(GROUP_FUNCTION);//2 Group Function

        $obj_item_type = new ItemType();
        $this->item_type = $obj_item_type->getAllItemTypes();

        return view('livewire.map.group-function.group_function_edit');
    }

    public function save()
    {
        $this->validate();
        // dd($this->GroupFunction);
        DB::beginTransaction();

        try {
            // Update GroupFunction
            $GroupFunction = GroupFunction::findOrFail($this->GroupFunction_id);
            $GroupFunction->update([
                'TitleId' => $this->GroupFunction['TitleId'],
                'IconUrl' => $this->GroupFunction['IconUrl'],  
                'Status' => (int) $this->GroupFunction['Status'],
                'ModifiDate' => now(),
            ]);

            DB::commit();

            return redirect()->route('groupfunction')->with(['message' => __('Update Successful'), 'status' => 'success']);
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
            // Delete GroupFunction
            GroupFunction::where('Id', $this->GroupFunction_id)
                ->update(['Status' => 3,'ModifiDate' => now()]);

            DB::commit();

            return redirect()->route('groupfunction')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}