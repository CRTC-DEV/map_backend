<?php

namespace App\Http\Livewire\Map\FaqType;

use App\Traits\LogsMapActivity;

use App\Models\Map\FaqType;
use App\Models\ItemTitle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class FaqTypeDetailLive extends Component
{
    use WithFileUploads, LogsMapActivity;

    public $message;
    public $faq_type_id;
    public $FaqType;
    public $item_title;

    public function rules()
    {
        return [
            'FaqType.TitleId' => 'required|numeric',
            'FaqType.Status' => 'required|numeric',
            'FaqType.OrderIndex' => 'required|numeric',
            
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {
        $this->logMapPageView('Faq Type Detail Page');


        $this->faq_type_id = (int) $id;
        $this->FaqType = FaqType::findOrFail($this->faq_type_id)->toArray();
    }

    public function render()
    {
        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getItemsWithType(FAQTYPE);

        return view('livewire.map.faq-type.faq_type_edit');
    }

    public function save()
    {
        $this->logMapAttempt('SAVE', 'Faq Type Detail');

        $this->validate();
        // dd('Validation passed');
        DB::beginTransaction();

        try {
            // Update FaqType
            $faq_type = FaqType::findOrFail((int) $this->faq_type_id);
            $faq_type->update([
                'TitleId' => $this->FaqType['TitleId'],
                'Status' => $this->FaqType['Status'],
                'OrderIndex' => $this->FaqType['OrderIndex'],
                'ModifiDate' => now(),
            ]);

            DB::commit();
            
            return redirect()->route('faq-type')->with(['message' => __('Update Successful'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

    public function delete()
    {
        $this->logMapAttempt('DELETE', 'Faq Type Detail');

        DB::beginTransaction();

        try {
            // Delete FaqType
            FaqType::where('Id', $this->faq_type_id)
                ->update(['Status' => 3,'ModifiDate' => now()]);

            DB::commit();

            return redirect()->route('faq-type')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}