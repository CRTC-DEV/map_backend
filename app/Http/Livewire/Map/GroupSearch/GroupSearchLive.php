<?php

namespace App\Http\Livewire\Map\GroupSearch;

use App\Models\Map\GroupSearch;
use Livewire\Component;
use App\Models\ItemTitle;

class GroupSearchLive extends Component
{
    public $item_type;
    public $group_search;
    public $item_title;

    public function mount(){
        // $obj_item = new ItemDescription();
        $obj_group_searchs= new GroupSearch();
        $this->group_search = $obj_group_searchs->getAllItems();
        $obj_item_title = new ItemTitle();
        $this->item_title = $obj_item_title->getAllItems();
        // dd($this->item_type);
    }
    public function render()
    {
        return view('livewire.map.group-search.group_search');
    }
}
