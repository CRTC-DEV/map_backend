<?php

namespace App\Http\Livewire\Map\ContactNumber;

use App\Traits\LogsMapActivity;

use App\Models\Map\ContactNumber;
use Livewire\Component;

class ContactNumberLive extends Component
{
    
    
    use LogsMapActivity;
public $contact_number;
    public $item_title;
    public function mount(){
        $this->logMapPageView('Contact Number Page');


        $obj_contact_number_device_touchs= new ContactNumber();
        $this->contact_number = $obj_contact_number_device_touchs->getAllContactNumber();
        // dd($this->contact_number);
    }

    public function render()
    {
        return view('livewire.map.contact-number.contact_number_list');
    }
}
