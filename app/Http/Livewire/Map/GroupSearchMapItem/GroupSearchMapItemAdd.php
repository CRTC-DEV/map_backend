<?php
namespace App\Http\Livewire\Map\GroupSearchMapItem;

use App\Models\Map\GroupSearchMapItem;
use App\Models\Map\GroupSearch;
use App\Models\Map\MapItem;
use App\Models\ItemTitle;
use Livewire\Component;

class GroupSearchMapItemAdd extends Component
{
    public $message;
    public $group_search_map_item = ['Status' => 2, 'IsShowBothLocation' => 0, 'IsSearchAllFloor' => 0];
    public $item_title;
    public $group_search;
    
    // Properties for multi-add functionality
    public $selectedGroupSearch;
    public $selectedMapItems = [];
    public $mapItemPriorities = [];
    public $multiSettings = [
        'Status' => '2',
        'IsShowBothLocation' => '0',
        'IsSearchAllFloor' => '0'
    ];
    public $searchMapItem = '';
    public $filteredMapItems = [];
    
    public function rules()
    {
        return [
            'group_search_map_item.MapItemId' => 'required|numeric',         
            'group_search_map_item.GroupSearchId' => 'required|numeric',
            'group_search_map_item.Status' => 'required|numeric',           
            'group_search_map_item.Priority' => 'required|numeric',
            'group_search_map_item.IsShowBothLocation' => 'required|boolean',
            'group_search_map_item.IsSearchAllFloor' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    public function mount()
    {
        $this->loadMapItems();
    }

    public function loadMapItems()
    {
        $query = MapItem::where('Status', '!=', DELETED_FLG);
        
        if (!empty($this->searchMapItem)) {
            $query->where(function ($q) {
                $q->where('CadId', 'like', '%' . $this->searchMapItem . '%')
                  ->orWhere('KeySearch', 'like', '%' . $this->searchMapItem . '%');
            });
        }
        
        $this->filteredMapItems = $query->get();
    }

    public function updatedSearchMapItem()
    {
        $this->loadMapItems();
    }

    public function render()
    {
        $obj_group_search = new GroupSearch();
        $this->group_search = $obj_group_search->getAllItems();
        $this->loadMapItems();
        
        return view('livewire.map.group-search-map-item.group_search_map_item_add');
    }

    public function save()
    {
        $this->validate();

        $obj_group_search = new GroupSearchMapItem();
        $obj_group_search->insertItem($this->group_search_map_item);

        return redirect()->route('group-search-map-item')->with(['message' => __('be_msg.add_complete'), 'status' => 'success']);
    }
    
    public function openMultiAddModal()
    {
        $this->loadMapItems();
        $this->emit('openMultiAddModal');
    }
    
    public function saveMultipleMapItems()
    {
        $this->validate([
            'selectedGroupSearch' => 'required',
            'multiSettings.Status' => 'required',
            'multiSettings.IsShowBothLocation' => 'required',
            'multiSettings.IsSearchAllFloor' => 'required',
            'selectedMapItems' => 'required|array|min:1',
        ], [
            'selectedGroupSearch.required' => 'Please select a Group Search',
            'multiSettings.Status.required' => 'Status is required',
            'multiSettings.IsShowBothLocation.required' => 'Show Both Location setting is required',
            'multiSettings.IsSearchAllFloor.required' => 'Search All Floor setting is required',
            'selectedMapItems.required' => 'Please select at least one Map Item',
            'selectedMapItems.min' => 'Please select at least one Map Item',
        ]);
        
        $successCount = 0;
        $failCount = 0;
        $obj_group_search = new GroupSearchMapItem();
        
        foreach ($this->selectedMapItems as $mapItemId) {
            // Prepare the data for insertion
            $data = [
                'GroupSearchId' => $this->selectedGroupSearch,
                'MapItemId' => $mapItemId,
                'Status' => $this->multiSettings['Status'],
                'IsShowBothLocation' => $this->multiSettings['IsShowBothLocation'],
                'IsSearchAllFloor' => $this->multiSettings['IsSearchAllFloor'],
                'Priority' => isset($this->mapItemPriorities[$mapItemId]) ? $this->mapItemPriorities[$mapItemId] : 0,
            ];
            
            try {
                $obj_group_search->insertItem($data);
                $successCount++;
            } catch (\Exception $e) {
                $failCount++;
            }
        }
        
        // Reset the form
        $this->resetMultiAddForm();
        
        // Notify the user using session flash for the modal
        session()->flash('messages', "Added $successCount map items to group search successfully" . 
                          ($failCount > 0 ? " ($failCount failed)" : ""));
        session()->flash('status', $failCount > 0 ? 'warning' : 'success');
        
        // Emit events for UI updates
        $this->emit('mapItemsAdded');
        $this->emit('closeMultiAddModal');
    }
    
    public function resetMultiAddForm()
    {
        $this->selectedGroupSearch = null;
        $this->selectedMapItems = [];
        $this->mapItemPriorities = [];
        $this->multiSettings = [
            'Status' => '2',
            'IsShowBothLocation' => '0',
            'IsSearchAllFloor' => '0'
        ];
        $this->searchMapItem = '';
        $this->loadMapItems();
    }
}
