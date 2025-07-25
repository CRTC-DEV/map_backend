<?php

namespace App\Http\Livewire\Map\ItemDescription;

use App\Traits\LogsMapActivity;

use App\Models\ItemDescription;
use App\Models\Map\MapItem;
use Livewire\Component;

class ItemDescriptionLive extends Component
{
    
    use LogsMapActivity;
public $item_description;
    public function mount(){
        $this->logMapPageView('Item Description Page');

        // $obj_item = new ItemDescription();
        $obj_map_items= new ItemDescription();
        $this->item_description = $obj_map_items->getAllItem();
        // dd($this->item_description);
    }
    public function render()
    {   
        return view('livewire.map.item-description.item_description_list');
    }
}
