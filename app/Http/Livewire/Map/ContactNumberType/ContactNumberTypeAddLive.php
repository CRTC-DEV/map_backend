<?php
namespace App\Http\Livewire\Map\ContactNumberType;

use App\Traits\LogsMapActivity;

use Illuminate\Support\Facades\DB;
use App\Models\ItemTitle;
use App\Models\Map\ContactNumberType;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContactNumberTypeAddLive extends Component
{
    use WithFileUploads, LogsMapActivity;
    public $message;
    public $ContactNumberType=['Status' => 2];
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
        return [
            
        ];
    }

    public function mount()
    {
        $this->logMapPageView('Contact Number Type Add Page');


    }

    public function render()
    {
        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getItemsWithType(CONTACTNUMBERTYPE);


        return view('livewire.map.contact-number-type.contact_number_type_add');
    }


    public function save()
    {
        $this->logMapAttempt('SAVE', 'Contact Number Type Add');

        $this->validate();
        
        DB::beginTransaction();

        try {
            // Create ContactNumberType
            $contact_number_type = ContactNumberType::create([
                'TitleId' => $this->ContactNumberType['TitleId'],
                'Status' => $this->ContactNumberType['Status'],
                'OrderIndex' => $this->ContactNumberType['OrderIndex'],
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),

            ]);

            DB::commit();

            return redirect()->route('contact-number-type')->with(['message' => __('Insert Successfull'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }


}
