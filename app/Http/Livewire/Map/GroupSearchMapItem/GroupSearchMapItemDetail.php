<?php

namespace App\Http\Livewire\Map\GroupSearchMapItem;

use App\Models\Map\GroupSearchMapItem;
use App\Models\Map\GroupSearch;
use App\Models\ItemTitle;
use App\Models\Map\MapItem;

use Livewire\Component;

class GroupSearchMapItemDetail extends Component
{

    public $message;
    public $group_search_map_item;
    public $group_search_map_item_id;
    public $group_search;
    public $map_item;
    public $group_search_id;
    public $map_item_id;
    public $map_item_id_old;
    public function rules()
    {
        return [            'group_search_map_item.MapItemId' => 'required|numeric',         
            'group_search_map_item.GroupSearchId' => 'required|numeric',
            'group_search_map_item.Status' => 'required|numeric',           
            'group_search_map_item.Priority' => 'required|numeric',
            'group_search_map_item.IsShowBothLocation' => 'required|boolean',
            'group_search_map_item.IsSearchAllFloor' => 'required|boolean',

            'group_search.Name'=> 'required',
            'group_search.KeySearch'=> 'required',
            'group_search.Description'=> 'required',
            'group_search.Status' => 'required|numeric',
            'group_search.Priority' => 'required|numeric',
            'group_search.Rank' => 'required|numeric',
            // 'group_search.TitleId' => 'required',

            // 'item_title.Name'=>'required'
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }

    public function mount($id)
    {
        
        [$this->group_search_id, $this->map_item_id] = explode(",", $id);
        $obj_group_search_map_item = new GroupSearchMapItem();
        $this->group_search_map_item = $obj_group_search_map_item->getItemById($this->group_search_id, $this->map_item_id);

        $obj_group_search = new GroupSearch();
        $this->group_search = $obj_group_search->getItemById($this->group_search_id);

        $this->map_item_id_old = $this->map_item_id;
        // $this->item_title = (new ItemTitle())->getItemById($this->group_search->TitleId); 
        // dd($this->item_title);
        
        // dd($this->group_search_map_item);
    }

    public function render()
    {
        $obj_map_item = new MapItem();
        $this->map_item = $obj_map_item->getAllMapItems();
        $this->map_item_id = $this->group_search_map_item['MapItemId'];
        return view('livewire.map.group-search-map-item.group_search_map_item_edit');
    }

    public function save(){

        $this->validate();

        // dd($this->group_search_map_item, $this->group_search, $this->map_item_id, $this->group_search_id, $this->map_item_id_old);

        $obj_group_search_map_item = new GroupSearchMapItem();
        $obj_group_search_map_item->updateItem($this->group_search_map_item, $this->group_search_id, $this->map_item_id_old);
        
        // $this->group_search->save();
        $obj_group_search = new GroupSearch();
        $obj_group_search->updateItem($this->group_search, $this->group_search_id);

        return redirect()->route('group-search-map-item')->with(['message' => __('be_msg.add_complete'), 'status' => 'success']);

    }

    public function delete()
    {   
       
        $obj_group_search = new GroupSearchMapItem();
        $obj_group_search->deleteItem($this->map_item_id, $this->group_search_id);
                
        return redirect()->route('group-search-map-item')->with(['message' => __('be_msg.delete_success'), 'status' => 'success']);
    }
}
