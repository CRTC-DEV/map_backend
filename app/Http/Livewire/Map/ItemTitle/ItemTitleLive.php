<?php

namespace App\Http\Livewire\Map\ItemTitle;

use App\Traits\LogsMapActivity;

use App\Models\ItemTitle;
use App\Models\Map\MapItem;
use Livewire\Component;

class ItemTitleLive extends Component
{
    
    use LogsMapActivity;
public $item_title;
    public function mount(){
        $this->logMapPageView('Item Title Page');

        // $obj_item = new ItemTitle();
        $obj_map_items= new ItemTitle();
        $this->item_title = $obj_map_items->getAllItems();
        // dd($this->item_title);
    }
    public function render()
    {   
        return view('livewire.map.item-title.item_title_list');
    }
}
