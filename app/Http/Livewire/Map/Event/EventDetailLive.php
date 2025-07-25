<?php

namespace App\Http\Livewire\Map\Event;

use App\Models\Map\Event;
use App\Models\Map\ItemType;
use App\Models\ItemDescription;
use App\Models\ItemTitle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Map\T2Location;
use App\Models\Map\GroupSearch;

class EventDetailLive extends Component
{
    use WithFileUploads;

    public $message;
    public $event_id;
    public $Event;
    public $item_title;
    public $item_type;
    public $item_description;
    public $t2_location;
    public $group_search;

    public function rules()
    {
        return [
            // Event validation rules
            'Event.T2LocationId' => 'required|numeric',
            'Event.TitleId' => 'required|numeric',
            'Event.DescriptionId' => 'required|numeric',
            'Event.Longitudes' => 'required|numeric',
            'Event.Latitudes' => 'required|numeric',
            'Event.Status' => 'required|numeric',
            'Event.EventStatus' => 'required|numeric',
            'Event.ImagePathName' => '',
            'Event.Rank' => '',
            'Event.LinkURL' => '',
            'Event.GroupSearchId' => '',
            'Event.PeriodFrom' => 'required',
            'Event.PeriodTo' => 'required|after:Event.PeriodFrom',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($id)
    {

        $this->event_id = (int) $id;
        $this->Event = Event::findOrFail($this->event_id)->toArray();
    }

    public function render()
    {
        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getItemsWithType(EVENT);

        $obj_item_description = new ItemDescription();
        $this->item_description = $obj_item_description->getAllItem();

        $obj_t2_location = new T2Location();
        $this->t2_location = $obj_t2_location->getAllT2Location();
        // dd($this->t2_location);

        $obj_item_type = new ItemType();
        $this->item_type = $obj_item_type->getAllItemTypes();

        $obj_group_search = new GroupSearch();
        $this->group_search = $obj_group_search->getAllItems();

        return view('livewire.map.event.event_edit');
    }

    public function save()
    {
        $this->validate();
        // dd('Validation passed');
        DB::beginTransaction();

        try {
            // Update Event
            $event = Event::findOrFail((int) $this->event_id);
            // dd($this->event_id,$event->toArray(), $this->Event);
            $event->update([

                'TitleId' => $this->Event['TitleId'],
                'Longitudes' => $this->Event['Longitudes'],
                'Latitudes' => $this->Event['Latitudes'],
                'DescriptionId' => $this->Event['DescriptionId'],
                'T2LocationId' => $this->Event['T2LocationId'],
                'Status' => $this->Event['Status'],
                'EventStatus' => $this->Event['EventStatus'],
                'ImagePathName' => $this->Event['ImagePathName'],
                'LinkURL' => $this->Event['LinkURL'],
                'GroupSearchId' => $this->Event['GroupSearchId'],
                'PeriodFrom' => $this->Event['PeriodFrom'],
                'PeriodTo' => $this->Event['PeriodTo'],
                'ModifiDate' => now(),
            ]);
            // dd($event->toArray(), $this->Event);
            DB::commit();
            
            return redirect()->route('event')->with(['message' => __('Update Successful'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }

    public function delete()
    {
        DB::beginTransaction();

        try {
            // Delete Event
            Event::where('Id', $this->event_id)
                ->update(['Status' => 3,'ModifiDate' => now()]);

            DB::commit();

            return redirect()->route('event')->with(['message' => __('Deleted successfully'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }
}