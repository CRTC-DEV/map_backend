<?php

namespace App\Http\Livewire\Map\Event;

use App\Traits\LogsMapActivity;

use App\Models\Map\Event;
use Livewire\Component;

class EventLive extends Component
{
    
    
    use LogsMapActivity;
public $event;
    public $item_title;
    public function mount(){
        $this->logMapPageView('Event Page');

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
