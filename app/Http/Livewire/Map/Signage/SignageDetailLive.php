<?php

namespace App\Http\Livewire\Map\Signage;

use App\Models\Signage;
use App\Models\Map\ItemType;
use App\Models\Map\Signages;
use App\Models\ItemTitle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Map\T2Location;

class SignageDetailLive extends Component
{
    use WithFileUploads;

    public $message;
    public $signage_id;
    public $Signage;
    public $item_title;
    public $item_type;

    public function rules()
    {
        return [
            // Signage validation rules
            'Signage.CadId' => 'required|string|max:255',
            'Signage.TitleId' => 'required|numeric',
            'Signage.Longitudes' => 'required|numeric',
            'Signage.Latitudes' => 'required|numeric',
            'Signage.Status' => 'required|numeric',
            'Signage.Description' => '',
            'Signage.IconUrl' => '',
            'Signage.MapUrl' => '',
            'Signage.BackgroundUrl' => '',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {

        $this->signage_id = $id;
        $this->Signage = Signages::findOrFail($this->signage_id)->toArray();
    }

    public function render()
    {
        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getItemsWithType(SIGNAGE);//signage

        $obj_item_type = new ItemType();
        $this->item_type = $obj_item_type->getAllItemTypes();

        return view('livewire.map.signage.signage_edit');
    }

    public function save()
    {
        $this->validate();
        // dd($this->Signage);
        DB::beginTransaction();

        try {
            // Update Signage
            $signage = Signages::findOrFail($this->signage_id);
            $signage->update([
                'CadId' => $this->Signage['CadId'],
                'TitleId' => $this->Signage['TitleId'],
                'Longitudes' => $this->Signage['Longitudes'],
                'Latitudes' => $this->Signage['Latitudes'],
                'Status' => (int) $this->Signage['Status'],
                'Description' => $this->Signage['Description'],
                'IconUrl' => $this->Signage['IconUrl'],
                'MapUrl' => $this->Signage['MapUrl'],
                'BackgroundUrl' => $this->Signage['BackgroundUrl'],
                'ModifiDate' => now(),
            ]);

            DB::commit();

            return redirect()->route('signage')->with(['message' => __('Update Successful'), 'status' => 'success']);
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
            // Delete Signage
            Signages::where('Id', $this->signage_id)
                ->update(['Status' => 3,'ModifiDate' => now()]);

            DB::commit();

            return redirect()->route('signage-')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}