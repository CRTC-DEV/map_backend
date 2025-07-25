<?php

namespace App\Http\Livewire\Map\Event;

use App\Models\Map\Event;
use Livewire\Component;

class EventLive extends Component
{
    
    public $event;
    public $item_title;
    public function mount(){
        // $obj_item = new ItemDescription();
        $obj_event_device_touchs= new Event();
        $this->event = $obj_event_device_touchs->getAllEvent();
        // dd($this->event);
    }

    public function render()
    {
        return view('livewire.map.event.event_list');
    }
}
