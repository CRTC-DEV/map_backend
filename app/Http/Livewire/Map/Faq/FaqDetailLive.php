<?php

namespace App\Http\Livewire\Map\Faq;

use App\Models\Map\Faq;
use App\Models\ItemDescription;
use App\Models\ItemTitle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Map\FaqType;

class FaqDetailLive extends Component
{
    use WithFileUploads;

    public $message;
    public $faq_id;
    public $Faq;
    public $item_title;
    public $item_description;
    public $faq_type;

    public function rules()
    {
        return [
            // Faq validation rules
           'Faq.FAQTypeId' => 'required|numeric',
           'Faq.TitleId' => 'required|numeric',
           'Faq.DescriptionId' => 'required|numeric',
           'Faq.Status' => 'required|numeric',
           'Faq.Rank' => '',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {

        $this->faq_id = (int) $id;
        $this->Faq = Faq::findOrFail($this->faq_id)->toArray();
    }

    public function render()
    {
        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getItemsWithType(FAQ);

        $obj_item_description = new ItemDescription();
        $this->item_description = $obj_item_description->getAllItem();

        $obj_faq_type = new FaqType();
        $this->faq_type = $obj_faq_type->getAllFaqType();

        return view('livewire.map.faq.faq_edit');
    }

    public function save()
    {
        $this->validate();
        // dd('Validation passed');
        DB::beginTransaction();

        try {
            // Update Faq
            $faq = Faq::findOrFail((int) $this->faq_id);
            $faq->update([

                'TitleId' => $this->Faq['TitleId'],
                'DescriptionId' => $this->Faq['DescriptionId'],
                'FAQTypeId' => $this->Faq['FAQTypeId'],
                'Status' => $this->Faq['Status'],
                'ModifiDate' => now(),
            ]);
            
            DB::commit();
            
            return redirect()->route('faq')->with(['message' => __('Update Successful'), 'status' => 'success']);
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
            // Delete Faq
            Faq::where('Id', $this->faq_id)
                ->update(['Status' => 3,'ModifiDate' => now()]);

            DB::commit();

            return redirect()->route('faq')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}