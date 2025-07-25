<?php
namespace App\Http\Livewire\Map\Event;

use App\Models\Map\ItemType;
use Illuminate\Support\Facades\DB;
use App\Models\ItemTitle;
use App\Models\Map\Event;
use App\Models\ItemDescription;
use App\Models\Map\T2Location;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Map\GroupFunction;
use App\Models\Map\GroupSearch;

class EventAddLive extends Component
{
    use WithFileUploads;
    public $message;
    public $Event=['Status' => 2];
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
        return [
            
        ];
    }

    public function mount()
    {

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

        // dd($this->group_search);


        return view('livewire.map.event.event_add');
    }


    public function save()
    {
        $this->validate();
        // dd($this->Event);
        DB::beginTransaction();

        try {
            // Create Event
            $event = Event::create([
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
                'CreatedDate' => now(),
                'ModifiDate' => now(),
                'UserId' => auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null),
                'Rank' => 1,

            ]);

            DB::commit();

            return redirect()->route('event')->with(['message' => __('Insert Successfull'), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('status', 'danger');
        }
    }


}
