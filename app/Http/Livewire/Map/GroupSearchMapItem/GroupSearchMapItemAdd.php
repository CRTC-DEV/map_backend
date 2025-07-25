<?php
namespace App\Http\Livewire\Map\GroupSearchMapItem;

use App\Models\Map\GroupSearchMapItem;
use App\Models\Map\GroupSearch;
use App\Models\ItemTitle;
use Livewire\Component;

class GroupSearchMapItemAdd extends Component
{

    public $message;
    public $group_search_map_item = ['Status' => 2, 'IsShowBothLocation' => 0];
    //public $group_search;
    public $item_title;
    public $group_search;
    public function rules()
    {
        return [            'group_search_map_item.MapItemId' => 'required|numeric',         
            'group_search_map_item.GroupSearchId' => 'required|numeric',
            'group_search_map_item.Status' => 'required|numeric',           
            'group_search_map_item.Priority' => 'required|numeric',
            'group_search_map_item.IsShowBothLocation' => 'required|boolean',
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
        $obj_group_search = new GroupSearch();
        $this->group_search = $obj_group_search->getAllItems();
        return view('livewire.map.group-search-map-item.group_search_map_item_add');
    }

    public function save(){
        
        $this->validate();

        $obj_group_search = new GroupSearchMapItem();
        $obj_group_search->insertItem($this->group_search_map_item);

        return redirect()->route('group-search-map-item')->with(['message' => __('be_msg.add_complete'), 'status' => 'success']);

    }
}
