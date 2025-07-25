<?php

namespace App\Http\Livewire\Map\RouteMapItemDetail;

use App\Traits\LogsMapActivity;

use App\Models\Map\RouteMapItemDetail;
use Livewire\Component;

class RouteMapItemDetailListLive extends Component
{
    
    use LogsMapActivity;
public $route_map_item_detail_detail;
    public function mount(){
        $this->logMapPageView('Route Map Item Detail List Page');

        // $obj_item = new ItemTitle();
        $obj_route_map_item_detail_detail= new RouteMapItemDetail();
        $this->route_map_item_detail_detail = $obj_route_map_item_detail_detail->getAllRouteMapItemDetail();
        // dd($this->map_item);
    }
    public function render()
    {   
        return view('livewire.map.route-map-item-detail.route_map_item_detail_list');
    }
}
