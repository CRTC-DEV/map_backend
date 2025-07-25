<?php

namespace App\Http\Livewire\Map\ItemType;

use App\Models\ItemTitle;
use App\Models\Map\ItemType;
use Livewire\Component;

class ItemTypeLive extends Component
{
    public $item_type;
    public function mount(){
        // $obj_item = new ItemTitle();
        $obj_item_types= new ItemType();
        $this->item_type = $obj_item_types->getAllItemTypes();
        // dd($this->item_type);
    }
    public function render()
    {
        return view('livewire.map.item-type.item_type');
    }
}
