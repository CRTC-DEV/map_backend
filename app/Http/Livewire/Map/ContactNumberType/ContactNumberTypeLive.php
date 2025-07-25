<?php

namespace App\Http\Livewire\Map\ContactNumberType;

use App\Models\Map\ContactNumberType;
use Livewire\Component;

class ContactNumberTypeLive extends Component
{
    
    public $contact_number_type;
    public $item_title;
    public function mount(){
        // $obj_item = new ItemDescription();
        $obj_contact_number_type_device_touchs= new ContactNumberType();
        $this->contact_number_type = $obj_contact_number_type_device_touchs->getAllContactNumberType();
        // dd($this->contact_number_type);
    }

    public function render()
    {
        return view('livewire.map.contact-number-type.contact_number_type_list');
    }
}
