<?php

namespace App\Http\Livewire\Map\SignageMapItem;

use App\Models\Map\SignageMapItem;
use Livewire\Component;

class SignageMapItemLive extends Component
{
    public $item_type;
    public $signage_mapitem;
    public $item_title;
    public function mount(){
        
        $obj_signage_mapitem= new SignageMapItem();
        $this->signage_mapitem = $obj_signage_mapitem->getAllSignageMapItem();
        // dd($this->signage_mapitem);
    }

    public function render()
    {
        return view('livewire.map.signage-mapitem.signage_mapitem_list');
    }
}
