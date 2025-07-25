<?php
namespace App\Http\Livewire\Map\ContactNumber;

use App\Traits\LogsMapActivity;

use App\Models\Map\ContactNumber;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Map\ContactNumberType;

class ContactNumberDetailLive extends Component
{
    use WithFileUploads, LogsMapActivity;

    public $message;
    public $contact_number_id;
    public $ContactNumber;
    public $contact_number_type;

    public function rules()
    {
        return [
            // ContactNumber validation rules
           'ContactNumber.ContactNumberTypeId' => 'required|numeric',
           'ContactNumber.NameId' => 'required|numeric',
           'ContactNumber.TerminalId' => 'required|numeric',
           'ContactNumber.Status' => 'required|numeric',
           'ContactNumber.PhoneNumberId' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {
        $this->logMapPageView('Contact Number Detail Page');


        $this->contact_number_id = (int) $id;
        $this->ContactNumber = ContactNumber::findOrFail($this->contact_number_id)->toArray();
    }

    public function render()
    {

        $obj_contact_number_type = new ContactNumberType();
        $this->contact_number_type = $obj_contact_number_type->getAllContactNumberType();

        return view('livewire.map.contact-number.contact_number_edit');
    }

    public function save()
    {
        $this->logMapAttempt('SAVE', 'Contact Number Detail');

        $this->validate();
        // dd('Validation passed');
        DB::beginTransaction();

        try {
            // Update ContactNumber
            $contact_number = ContactNumber::findOrFail((int) $this->contact_number_id);
            $contact_number->update([

                'ContactNumberTypeId' => $this->ContactNumber['ContactNumberTypeId'],
                'NameId' => $this->ContactNumber['NameId'],
                'TerminalId' => $this->ContactNumber['TerminalId'],
                'PhoneNumberId' => $this->ContactNumber['PhoneNumberId'],
                'Status' => $this->ContactNumber['Status'],
                'ModifiDate' => now(),
            ]);
            
            DB::commit();
            
            return redirect()->route('contact-number')->with(['message' => __('Update Successful'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

    public function delete()
    {
        $this->logMapAttempt('DELETE', 'Contact Number Detail');

        DB::beginTransaction();

        try {
            // Delete ContactNumber
            ContactNumber::where('Id', $this->contact_number_id)
                ->update(['Status' => 3,'ModifiDate' => now()]);

            DB::commit();

            return redirect()->route('contact-number')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}