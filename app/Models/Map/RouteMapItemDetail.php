<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;


class RouteMapItemDetail extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'RouteMapItemDetail';

    // Add fields that can be mass-assigned
    protected $fillable = [ 'RouteMapItemId', 'NameIndex', 'Status', 'CreatedDate', 'ModifiDate', 'UserId', 'Longitudes','Latitudes','OrderIndex']; // Example fields
    public $timestamps = false;

    function getAllRouteMapItemDetail(){
        // $Language =  RouteMapItemDetailRouteMapItemDetailMapItem::All();
        $data =  RouteMapItemDetail::where('RouteMapItemDetail.Status', '!=', DELETED_FLG)
            ->join('RouteMapItem','RouteMapItem.Id','=','RouteMapItemId')
            ->select('RouteMapItemDetail.*','RouteMapItem.Name as RouteMapItemName')->get();
            // dd($data);
        return $data;
    }

    function insertRouteMapItemDetail($data){
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return RouteMapItemDetail::insertGetId($data);
    }
    function updateRouteMapItemDetail($data, $route_map_item_id, $longitudes, $latitudes){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        return RouteMapItemDetail::where('RouteMapItemId', $route_map_item_id)
        ->where('Longitudes', $longitudes)
        ->where('Latitudes', $latitudes)->update($data->toArray());
    }
    function deleteRouteMapItemDetail($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        return RouteMapItemDetail::where('Id', $id)->update($data);
    }

    function getRouteMapItemDetailById($route_map_item_id, $longitudes, $latitudes){
        $return = RouteMapItemDetail::where('RouteMapItemId', $route_map_item_id)
            ->where('Longitudes', $longitudes)
            ->where('Latitudes', $latitudes)
            ->first();
        return $return;
    }

    function getRouteMapItemDetailAPI($route_map_item_name){
        // $Language =  RouteMapItemDetailRouteMapItemDetailMapItem::All();
        $data =  RouteMapItemDetail::where('RouteMapItemDetail.Status', '!=', DELETED_FLG)
            ->where('RouteMapItem.Name', $route_map_item_name)
            ->join('RouteMapItem','RouteMapItem.Id','=','RouteMapItemId')
            ->select('RouteMapItemDetail.*','RouteMapItem.Name as RouteMapItemName')
            ->orderBy('RouteMapItemDetail.OrderIndex', 'asc')
            ->get();
            //dd($data);
        return $data;
    }

    
    
    
    
    
    
}
