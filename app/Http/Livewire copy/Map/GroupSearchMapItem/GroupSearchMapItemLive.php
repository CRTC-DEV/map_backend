<?php

namespace App\Http\Livewire\Map\GroupSearchMapItem;

use App\Models\Map\GroupSearch;
use App\Models\Map\GroupSearchMapItem;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class GroupSearchMapItemLive extends Component
{
    use WithPagination;
    private $group_search_map_item = [];
    public $group_search;
    public $search;
    public $input_search=[];

    public function mount(){
        // $this->input_search = $this->search;
        $this->group_search_map_item = (new GroupSearchMapItem())->getAllItemGroupSearchMapItem($this->input_search);
    }
    public function render()
    {
        $group_search_map_item = (new GroupSearchMapItem())->getAllItemGroupSearchMapItem($this->input_search);

        return view('livewire.map.group-search-map-item.group_search_map_item', [
            'group_search_map_item' => $group_search_map_item,
        ]);
    }

    public function search()
    {
        $this->search = $this->input_search;
        // $this->group_search_map_item = (new GroupSearchMapItem())->getAllItemGroupSearchMapItem($this->input_search);
        // Triggers re-render with the updated search term
        $this->resetPage(); // Reset pagination to the first page on search
    }
}
