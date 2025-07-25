<?php
namespace App\Http\Livewire\Map\ContactNumber;

use App\Traits\LogsMapActivity;

use Illuminate\Support\Facades\DB;
use App\Models\Map\ContactNumber;
use App\Models\Map\ContactNumberType;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContactNumberAddLive extends Component
{
    use WithFileUploads, LogsMapActivity;
    public $message;
    public $ContactNumber=['Status' => 2];
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
        return [
            
        ];
    }

    public function mount()
    {
        $this->logMapPageView('Contact Number Add Page');


    }

    public function render()
    {

        $obj_contact_number_type = new ContactNumberType();
        $this->contact_number_type = $obj_contact_number_type->getAllContactNumberType();
        // dd($this->contact_number_type);
        return view('livewire.map.contact-number.contact_number_add');
    }


    public function save()
    {
        $this->logMapAttempt('SAVE', 'Contact Number Add');

        $this->validate();
        // dd($this->ContactNumber);
        DB::beginTransaction();

        try {
            // Create ContactNumber
            $contact_number = ContactNumber::create([
                'ContactNumberTypeId' => $this->ContactNumber['ContactNumberTypeId'],
                'NameId' => $this->ContactNumber['NameId'],
                'TerminalId' => $this->ContactNumber['TerminalId'],
                'PhoneNumberId' => $this->ContactNumber['PhoneNumberId'],
                'Status' => $this->ContactNumber['Status'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),

            ]);

            DB::commit();

            return redirect()->route('contact-number')->with(['message' => __('Insert Successfull'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }


}
