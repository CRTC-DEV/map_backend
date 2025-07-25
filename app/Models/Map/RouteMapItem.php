<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;


class RouteMapItem extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'RouteMapItem';

    // Add fields that can be mass-assigned
    protected $fillable = [ 'StartMapItemId', 'EndMapItemId', 'Status', 'CreatedDate', 'ModifiDate', 'UserId']; // Example fields
    public $timestamps = false;

    function getAllRouteMapItem(){
        // $Language =  RouteMapItemRouteMapItemMapItem::All();
        $data =  RouteMapItem::where('RouteMapItem.Status', '!=', DELETED_FLG)
            ->join('MapItem as StartMapItem','StartMapItem.Id','=', 'StartMapItemId')
            ->join('MapItem as EndMapItem','EndMapItem.Id','=', 'EndMapItemId')
            ->join('ItemTitle as StartItemTitle', 'StartItemTitle.Id', '=', 'StartMapItem.TitleId')
            ->join('ItemTitle as EndItemTitle', 'EndItemTitle.Id', '=', 'EndMapItem.TitleId')
            ->join('TextContent as StartTitleText', 'StartTitleText.Id', '=', 'StartItemTitle.TextcontentId')
            ->join('TextContent as EndTitleText', 'EndTitleText.Id', '=', 'EndItemTitle.TextcontentId')
            ->select('RouteMapItem.*',
                            'StartTitleText.OriginalText as StartTitleTextContent' , 'EndTitleText.OriginalText as EndTitleTextContent')
                            ->get();
            // dd($data);
        return $data;
    }

    function insertRouteMapItem($data){
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return RouteMapItem::insertGetId($data);
    }
    function updateRouteMapItem($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        return RouteMapItem::where('Id', $id)->update($data->toArray());
    }
    function deleteRouteMapItem($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        return RouteMapItem::where('Id', $id)->update($data);
    }

    function getRouteMapItemById($id){
        $return = RouteMapItem::where('Id', $id)->first();
        return $return;
    }
}
