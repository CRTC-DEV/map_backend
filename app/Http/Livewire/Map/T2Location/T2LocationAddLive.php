<?php

namespace App\Http\Livewire\Map\T2Location;

use App\Traits\LogsMapActivity;

use App\Models\Map\T2Location;
use Livewire\Component;

class T2LocationAddLive extends Component
{

    
    use LogsMapActivity;
public $message;
    public $t2_location;

    public function rules()
    {
        return [
            't2_location.Zone' => 'required|numeric',
            't2_location.Floor' => 'required|numeric',
            't2_location.Status' => 'required|numeric',
            't2_location.Name' => 'required',

        ];
    }

    public function messages()
    {
        return [
    
        ];
    }

    public function mount()
    {
        $this->logMapPageView('T2 Location Add Page');


    }

    public function render()
    {
        return view('livewire.map.t2-location.t2_location_add');
    }

    public function save(){
        $this->logMapAttempt('SAVE', 'T2 Location Add');

        
        $this->validate();
        // dd($this->item_title);
        $obj_t2_location = new T2Location();
        $obj_t2_location->insertT2Location($this->t2_location);
        
        return redirect()->route('t2-location')->with(['message' => __('Insert Successfull'), 'status' => 'success']);

    }
}
