<?php

namespace App\Http\Livewire\Map\RouteMapItem;

use App\Traits\LogsMapActivity;

use App\Models\Map\MapItem;
use App\Models\Map\RouteMapItem;
use Livewire\Component;

class RouteMapItemAddLive extends Component
{

    
    use LogsMapActivity;
public $message;
    public $route_map_item;
    public $map_item;

    public function rules()
    {
        return [
            'route_map_item.StartMapItemId' => 'required',
            'route_map_item.EndMapItemId' => 'required|numeric',
            'route_map_item.Status' => 'required|numeric',
            'route_map_item.Name' => 'required',
        ];
    }

    public function messages()
    {
        return [
    
        ];
    }

    public function mount()
    {
        $this->logMapPageView('Route Map Item Add Page');

        
    }

    public function render()
    {
        $obj_map_item = new MapItem();
        $this->map_item = $obj_map_item->getAllMapItems();

        return view('livewire.map.route-map-item.route_map_item_add');
    }

    public function save(){
        $this->logMapAttempt('SAVE', 'Route Map Item Add');

        
        $this->validate();
        // dd($this->item_title);
        $obj_route_map_item = new RouteMapItem();
        $obj_route_map_item->insertRouteMapItem($this->route_map_item);
        
        return redirect()->route('route-map-item')->with(['message' => __('Insert Successfull'), 'status' => 'success']);

    }
}
