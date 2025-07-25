<?php

namespace App\Http\Livewire\Map\MainFunction;


use App\Models\Map\ItemType;
use App\Models\ItemTitle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Map\MainFunction;
use App\Models\Map\Signages;

class MainFunctionDetailLive extends Component
{
    use WithFileUploads;

    public $message;
    public $function_id;
    public $mainfunction;
    public $item_title;
    public $item_type;
    public $signages;
    public $selected_signagesId = [];

    public function rules()
    {
        return [
            // Function validation rules
            'mainfunction.TitleId' => 'required|numeric',
            'mainfunction.IconUrl' => 'required|string',
            'mainfunction.Link' => '',
            'mainfunction.Status' => 'required|numeric',
            'mainfunction.selected_signagesId' => '',
            'mainfunction.title' => '',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {

        $this->function_id = $id;
        $this->mainfunction = MainFunction::findOrFail($this->function_id)->toArray();
        $this->selected_signagesId = json_decode($this->mainfunction['SignagesId'], true) ?? [];

        $this->mainfunction['title'] = ((new MainFunction)->getFunctionById($id)->toArray())['title']['textcontent']['OriginalText'];

        // dd($this->mainfunction['title']);
    }

    public function render()
    {
        $obj_1 = new ItemTitle();
        $this->item_title = $obj_1->getItemsWithType(MAINFUNCTION);//3  Function
        
        $obj_2 = new ItemType();
        $this->item_type = $obj_2->getAllItemTypes();

        $this->signages = (new Signages())->getAllSignages();


        return view('livewire.map.mainfunction.mainfunction_edit');
    }

    public function save()
    {
        $this->validate();
        // dd($this->Function);
        DB::beginTransaction();

        try {
            // Update Function
            $mainfunction = MainFunction::findOrFail($this->function_id);
            $mainfunction->update([
                'TitleId' => $this->mainfunction['TitleId'],
                'IconUrl' => $this->mainfunction['IconUrl'],  
                'Link' => $this->mainfunction['Link'],
                'Status' => (int) $this->mainfunction['Status'],
                'ModifiDate' => now(),
                'SignagesId' => json_encode($this->selected_signagesId),
            ]);

            DB::commit();

            return redirect()->route('mainfunction')->with(['message' => __('Update Successful'), 'status' => 'success']);
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
            // Delete Function
            MainFunction::where('Id', $this->function_id)
                ->update(['Status' => 3,'ModifiDate' => now()]);

            DB::commit();

            return redirect()->route('mainfunction')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}