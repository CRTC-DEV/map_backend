<?php

namespace App\Http\Livewire\Map\KeySearch;

use App\Traits\LogsMapActivity;

use App\Models\Map\KeySearch;
use Livewire\Component;
use App\Models\ItemTitle;

class KeySearchLive extends Component
{
    
    use LogsMapActivity;
public $key_kearch;

    public function mount(){
        $this->logMapPageView('Key Search Page');

        // $obj_item = new ItemDescription();
        $obj_key_search = new KeySearch();
        $this->key_kearch = $obj_key_search->getAllItems();
        // dd($this->item_type);
    }
    public function render()
    {
        return view('livewire.map.key-search.key_search_list');
    }
}
