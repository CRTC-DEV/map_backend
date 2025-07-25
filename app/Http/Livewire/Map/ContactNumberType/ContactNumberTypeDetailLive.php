<?php

namespace App\Http\Livewire\Map\ContactNumberType;

use App\Models\Map\ContactNumberType;
use App\Models\ItemTitle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContactNumberTypeDetailLive extends Component
{
    use WithFileUploads;

    public $message;
    public $contact_number_type_id;
    public $ContactNumberType;
    public $item_title;

    public function rules()
    {
        return [
            'ContactNumberType.TitleId' => 'required|numeric',
            'ContactNumberType.Status' => 'required|numeric',
            'ContactNumberType.OrderIndex' => 'required|numeric',
            
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {

        $this->contact_number_type_id = (int) $id;
        $this->ContactNumberType = ContactNumberType::findOrFail($this->contact_number_type_id)->toArray();
    }

    public function render()
    {
        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getItemsWithType(CONTACTNUMBERTYPE);

        return view('livewire.map.contact-number-type.contact_number_type_edit');
    }

    public function save()
    {
        $this->validate();
        // dd('Validation passed');
        DB::beginTransaction();

        try {
            // Update ContactNumberType
            $contact_number_type = ContactNumberType::findOrFail((int) $this->contact_number_type_id);
            $contact_number_type->update([
                'TitleId' => $this->ContactNumberType['TitleId'],
                'Status' => $this->ContactNumberType['Status'],
                'OrderIndex' => $this->ContactNumberType['OrderIndex'],
                'ModifiDate' => now(),
            ]);

            DB::commit();
            
            return redirect()->route('contact-number-type')->with(['message' => __('Update Successful'), 'status' => 'success']);
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
            // Delete ContactNumberType
            ContactNumberType::where('Id', $this->contact_number_type_id)
                ->update(['Status' => 3,'ModifiDate' => now()]);

            DB::commit();

            return redirect()->route('contact_number-type')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}