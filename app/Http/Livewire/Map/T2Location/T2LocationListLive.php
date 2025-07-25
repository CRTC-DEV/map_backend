<?php

namespace App\Http\Livewire\Map\T2Location;

use App\Models\Map\T2Location;
use Livewire\Component;

class T2LocationListLive extends Component
{
    public $t2_location;
    public function mount(){
        // $obj_item = new ItemTitle();
        $obj_t2_location= new T2Location();
        $this->t2_location = $obj_t2_location->getAllT2Location();
        // dd($this->map_item);
    }
    public function render()
    {   
        return view('livewire.map.t2-location.t2_location_list');
    }
}
