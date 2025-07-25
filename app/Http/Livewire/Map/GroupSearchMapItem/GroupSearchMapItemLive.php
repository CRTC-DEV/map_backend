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
    
    public $group_search;
    public $search;
    public $input_search = '';
    public $per_page = 10;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        // Initialize per_page if not set
        if (!$this->per_page) {
            $this->per_page = 10;
        }
    }

    public function render()
    {
        $group_search_map_item = (new GroupSearchMapItem())->getAllItemGroupSearchMapItem($this->input_search, $this->per_page);

        return view('livewire.map.group-search-map-item.group_search_map_item', [
            'group_search_map_item' => $group_search_map_item,
        ]);
    }

    public function search()
    {
        $this->search = $this->input_search;
        $this->resetPage(); // Reset pagination to the first page on search
    }

    public function updatedPerPage()
    {
        $this->resetPage(); // Reset pagination when changing per page
    }

    public function updatedInputSearch()
    {
        $this->resetPage(); // Reset pagination when search input changes
    }
}
