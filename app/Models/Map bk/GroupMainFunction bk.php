<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use App\Models\Map\SignageMapItem;

class GroupMainFunction extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'GroupMainFunction';
    public $incrementing = false; // Không tự tăng
    protected $keyType = 'string';
    protected $primaryKey = null;

    // Add fields that can be mass-assigned
    protected $fillable = [ 'GroupFunctionId', 'MainFunctionId', 'CreatedDate', 'ModifiDate','UserId','Status','OrderIndex']; // Example fields
    public $timestamps = false;

    public function groupfunction()
    {
        return $this->belongsTo(GroupFunction::class, 'GroupFunctionId', 'Id');
    }

    public function mainfunction()
    {
        return $this->belongsTo(MainFunction::class, 'MainFunctionId', 'Id');
    }

    function getGroupMainFunction(){


        $data =  GroupMainFunction::where('GroupMainFunction.Status', '!=', DELETED_FLG)
                ->with([
                    'groupfunction.title.textcontent', 
                    'mainfunction.title.textcontent'
                ])->get();
                    
        // dd($data->toArray());
        return $data;
    }

    function insertGroupMainFunction($data){
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return GroupMainFunction::insertGetId($data);
    }
    function updateGroupMainFunction($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return GroupMainFunction::where('Id', $id)->update($data->toArray());
    }

    function deletdGroupMainFunction($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return GroupMainFunction::where('Id', $id)->update($data->toArray());
    }

    function getGroupMainFunctionById($GroupFunctionId,$MainFunctionId){
        $return = GroupMainFunction::where('GroupFunctionId', $GroupFunctionId)
            ->where('MainFunctionId',$MainFunctionId)->first();
        return $return;
    }

    //For API
    function getGroupMainFunctionAPI($DeviceId){
        $return = GroupMainFunction::where('Id', $DeviceId)
        ->get();
        return $return;
    }

    function postGroupMainFunctionBySinageAPI($GroupFunctionId)
    {
        $return = GroupMainFunction::where('GroupFunctionId', $GroupFunctionId)
        ->join('GroupFunction', 'GroupFunction.Id', '=', 'GroupMainFunction.GroupFunctionId')
        ->join('MainFunction', 'MainFunction.Id', '=', 'GroupMainFunction.MainFunctionId')
        ->select(   'GroupFunction.Id as G-Id',                
                    'MainFunction.Id as Sub-Id',
                    'MainFunction.SignagesId as Sub-SignagesId'
                    
        )
        ->get();
        return $return;
    }

    function getAllGroupMainFunctionBySinageAPI($GroupFunctionId){
        $return = GroupMainFunction::
        join('GroupFunction', 'GroupFunction.Id', '=', 'GroupMainFunction.GroupFunctionId')
        ->join('MainFunction', 'MainFunction.Id', '=', 'GroupMainFunction.MainFunctionId')
        ->select(   'GroupFunction.Id as G-Id',                
                    'MainFunction.Id as Sub-Id',
                    'MainFunction.SignagesId as Sub-SignagesId'
                    
        )
        ->get();
        return $return;
    }

    public function getGroupMainFunctionBySinage_bk($GroupFunctionId)
{
    $obj = new GroupMainFunction();
    $items = $obj->getGroupMainFunctionBySinageAPI($GroupFunctionId);

    $result = [];
    foreach ($items as $item) {
        $subIds = json_decode($item['Sub-SignagesId'], true);
        
        // Check if $subIds is an array and not empty
        if (is_array($subIds) && !empty($subIds)) {
            $subSignages = SignageMapItem::whereIn('SignageId', $subIds)
                ->join('MapItem', 'MapItem.Id', '=', 'SignageMapItem.MapItemId')
                ->select('SignageId as Sub-SignagesId', 'MapItemId as Sub-SignageMapId',
                'CadId as  Sub-SignageMapCadId',
                'Longitudes as Sub-SignageMapLongitudes',
                'Latitudes as Sub-SignageMapLatitudes'
                )
                ->get()
                ->groupBy('Sub-SignagesId')
                ->map(function ($group) {
                    return [
                        'Sub-SignagesId' => $group[0]['Sub-SignagesId'],
                        'Sub-SignageMapId' => $group->pluck('Sub-SignageMapId')->toArray(),
                        'Sub-SignageMapCadId' => $group->pluck('Sub-SignageMapCadId')->toArray(),
                        'Sub-SignageMapLongitudes' => $group->pluck('Sub-SignageMapLongitudes')->toArray(),
                        'Sub-SignageMapLatitudes' => $group->pluck('Sub-SignageMapLatitudes')->toArray(),
                        //'Coordinates' =>
                    ];
                })
                ->values()
                ->toArray();
        } else {
            $subSignages = []; // Set to empty array if $subIds is null or empty
        }

        if (!isset($result['G-Id'])) {
            $result['G-Id'] = $item['G-Id'];
        }

        if (!isset($result['Sub-Id'])) {
            $result['Sub-Id'] = [];
        }

        $result['Sub-Id'][] = [
            'Sub-Id' => $item['Sub-Id'],
            'Sub-SignagesId' => $subSignages
        ];
    }

    return $result;
}

public function getGroupMainFunctionBySinage_bk2($GroupFunctionId)
{
    $obj = new GroupMainFunction();
    $items = $obj->getGroupMainFunctionBySinageAPI($GroupFunctionId);

    $result = [];
    foreach ($items as $item) {
        if (!isset($result['G-Id'])) {
            $result['G-Id'] = $item['G-Id'];
            // Assuming you have a 'name' field in GroupFunction table
            $result['name'] = GroupFunction::find($item['G-Id'])->name ?? 'Unknown';
        }

        $subIds = json_decode($item['Sub-SignagesId'], true);
        
        if (is_array($subIds) && !empty($subIds)) {
            $subSignages = SignageMapItem::whereIn('SignageId', $subIds)
                ->join('MapItem', 'MapItem.Id', '=', 'SignageMapItem.MapItemId')
                ->select(
                    'SignageId as Sub-SignagesId',
                    'MapItemId as id',
                    'CadId as cadId',
                    'Longitudes',
                    'Latitudes'
                )
                ->get()
                ->groupBy('Sub-SignagesId')
                ->map(function ($group) {
                    return [
                        'Sub-SignageMapCadId' => $group->map(function ($item) {
                            return [
                                'id' => $item['id'],
                                'cadId' => $item['cadId'],
                                'coordinates' => [$item['Longitudes'], $item['Latitudes']]
                            ];
                        })->values()->toArray()
                    ];
                })
                ->values()
                ->toArray();
        } else {
            $subSignages = [];
        }

        if (!isset($result['Sub-Id'])) {
            $result['Sub-Id'] = [];
        }

        $result['Sub-Id'][] = [
            'Sub-Id' => $item['Sub-Id'],
            // Assuming you have a 'name' field in MainFunction table
            'name' => MainFunction::find($item['Sub-Id'])->name ?? 'Unknown',
            'Sub-SignagesId' => $subSignages
        ];
    }

    return $result;
}

public function getGroupMainFunctionBySinage($GroupFunctionId = null)
{
    $obj = new GroupMainFunction();
    $items = $obj->getAllGroupMainFunctionBySinageAPI($GroupFunctionId);

    $result = [];
    foreach ($items as $item) {
        $gId = $item['G-Id'];
        if (!isset($result[$gId])) {
            $result[$gId] = [
                'G-Id' => $gId,
                'name' => GroupFunction::find($gId)->name ?? 'Unknown',
                'Sub-Id' => []
            ];
        }

        $subIds = json_decode($item['Sub-SignagesId'], true);
        
        if (is_array($subIds) && !empty($subIds)) {
            $subSignages = SignageMapItem::whereIn('SignageId', $subIds)
                ->join('MapItem', 'MapItem.Id', '=', 'SignageMapItem.MapItemId')
                ->select(
                    'SignageId as Sub-SignagesId',
                    'MapItemId as id',
                    'CadId as cadId',
                    'Longitudes',
                    'Latitudes'
                )
                ->get()
                ->groupBy('Sub-SignagesId')
                ->map(function ($group) {
                    return [
                        'Sub-SignageMapCadId' => $group->map(function ($item) {
                            return [
                                'id' => $item['id'],
                                'cadId' => $item['cadId'],
                                'coordinates' => [$item['Longitudes'], $item['Latitudes']]
                            ];
                        })->values()->toArray()
                    ];
                })
                ->values()
                ->toArray();
        } else {
            $subSignages = [];
        }

        $result[$gId]['Sub-Id'][] = [
            'Sub-Id' => $item['Sub-Id'],
            'name' => MainFunction::find($item['Sub-Id'])->name ?? 'Unknown',
            'Sub-SignagesId' => $subSignages
        ];
    }

    return array_values($result);
}

public function postGroupMainFunctionBySinage($GroupFunctionId = null)
{
    $obj = new GroupMainFunction();
    $items = $obj->postGroupMainFunctionBySinageAPI($GroupFunctionId);

    $result = [];
    foreach ($items as $item) {
        $gId = $item['G-Id'];
        if (!isset($result[$gId])) {
            $result[$gId] = [
                'G-Id' => $gId,
                'name' => GroupFunction::find($gId)->name ?? 'Unknown',
                'Sub-Id' => []
            ];
        }

        $subIds = json_decode($item['Sub-SignagesId'], true);
        
        if (is_array($subIds) && !empty($subIds)) {
            $subSignages = SignageMapItem::whereIn('SignageId', $subIds)
                ->join('MapItem', 'MapItem.Id', '=', 'SignageMapItem.MapItemId')
                ->select(
                    'SignageId as Sub-SignagesId',
                    'MapItemId as id',
                    'CadId as cadId',
                    'Longitudes',
                    'Latitudes'
                )
                ->get()
                ->groupBy('Sub-SignagesId')
                ->map(function ($group) {
                    return [
                        'Sub-SignageMapCadId' => $group->map(function ($item) {
                            return [
                                'id' => $item['id'],
                                'cadId' => $item['cadId'],
                                'coordinates' => [$item['Longitudes'], $item['Latitudes']]
                            ];
                        })->values()->toArray()
                    ];
                })
                ->values()
                ->toArray();
        } else {
            $subSignages = [];
        }

        $result[$gId]['Sub-Id'][] = [
            'Sub-Id' => $item['Sub-Id'],
            'name' => MainFunction::find($item['Sub-Id'])->name ?? 'Unknown',
            'Sub-SignagesId' => $subSignages
        ];
    }

    return array_values($result);
}








}
