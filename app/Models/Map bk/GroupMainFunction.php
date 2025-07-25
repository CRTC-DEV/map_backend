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
    protected $fillable = ['GroupFunctionId', 'MainFunctionId', 'CreatedDate', 'ModifiDate', 'UserId', 'Status', 'OrderIndex']; // Example fields
    public $timestamps = false;

    public function groupfunction()
    {
        return $this->belongsTo(GroupFunction::class, 'GroupFunctionId', 'Id');
    }

    public function mainfunction()
    {
        return $this->belongsTo(MainFunction::class, 'MainFunctionId', 'Id');
    }

    function getGroupMainFunction()
    {


        $data =  GroupMainFunction::where('GroupMainFunction.Status', '!=', DELETED_FLG)
            ->with([
                'groupfunction.title.textcontent',
                'mainfunction.title.textcontent'
            ])->get();

        // dd($data->toArray());
        return $data;
    }

    function insertGroupMainFunction($data)
    {
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return GroupMainFunction::insertGetId($data);
    }
    function updateGroupMainFunction($data, $id)
    {

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return GroupMainFunction::where('Id', $id)->update($data->toArray());
    }

    function deletdGroupMainFunction($data, $id)
    {

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return GroupMainFunction::where('Id', $id)->update($data->toArray());
    }

    function getGroupMainFunctionById($GroupFunctionId, $MainFunctionId)
    {
        $return = GroupMainFunction::where('GroupFunctionId', $GroupFunctionId)
            ->where('MainFunctionId', $MainFunctionId)->first();
        return $return;
    }

    //For API
    function getGroupMainFunctionAPI($DeviceId)
    {
        $return = GroupMainFunction::where('Id', $DeviceId)
            ->get();
        return $return;
    }

    function postGroupMainFunctionBySinageAPI($GroupFunctionId)
    {
        $return = GroupMainFunction::where('GroupFunctionId', $GroupFunctionId)
            ->join('GroupFunction', 'GroupFunction.Id', '=', 'GroupMainFunction.GroupFunctionId')
            ->join('MainFunction', 'MainFunction.Id', '=', 'GroupMainFunction.MainFunctionId')
            ->select(
                'GroupFunction.Id as G-Id',
                'MainFunction.Id as Sub-Id',
                'MainFunction.SignagesId as Sub-SignagesId'

            )
            ->get();
        return $return;
    }

    function getAllGroupMainFunctionBySinageAPI($LangguaId)
    {
        $return = GroupMainFunction::join('GroupFunction', 'GroupFunction.Id', '=', 'GroupMainFunction.GroupFunctionId')
            ->where('GroupLanguages.Id', $LangguaId)
            ->where('SubLanguages.Id', $LangguaId)
            ->join('MainFunction', 'MainFunction.Id', '=', 'GroupMainFunction.MainFunctionId')
            
            //GroupFunction
            ->join('ItemTitle as GroupTitle', 'GroupTitle.Id', '=', 'GroupFunction.TitleId')
            ->join('Translations as GroupTranslations', 'GroupTranslations.TextcontentId', '=', 'GroupTitle.TextcontentId')
            ->join('Languages as GroupLanguages', 'GroupLanguages.Id', '=', 'GroupTranslations.LanguageId')
            
            //SubFunction
            ->join('ItemTitle as FunctionTitle', 'FunctionTitle.Id', '=', 'MainFunction.TitleId') 
            ->join('Translations as SubTranslations', 'SubTranslations.TextcontentId', '=', 'FunctionTitle.TextcontentId')
            ->join('Languages as SubLanguages', 'SubLanguages.Id', '=', 'SubTranslations.LanguageId')
            
            ->select(
                'GroupFunction.Id as G_Id',
                'GroupTranslations.Translation as G_Name',
                'GroupLanguages.Id as G_LanguageId',
                'GroupFunction.IconUrl as G_IconUrl',
              
                
                'MainFunction.Id as Sub_Id',
                'MainFunction.SignagesId as Sub_SignagesId',
                'SubTranslations.Translation as Sub_Name',
                'SubLanguages.Id as Sub_LanguageId',
                'MainFunction.IconUrl as Sub_IconUrl'


            )
            ->get();
            
        return $return;
    }





   

    public function getGroupMainFunctionBySinage($GroupFunctionId = null, $floor = null)
{
    $obj = new GroupMainFunction();
    $items = $obj->getAllGroupMainFunctionBySinageAPI($GroupFunctionId);

    $result = [];
    foreach ($items as $item) {
        $gId = $item['G_Id'];
        $subIds = json_decode($item['Sub_SignagesId'], true);
        
        if (is_array($subIds) && !empty($subIds)) {
            $subSignages = SignageMapItem::whereIn('SignageId', $subIds)
                ->join('MapItem', 'MapItem.Id', '=', 'SignageMapItem.MapItemId')
                ->join('T2Location', 'T2Location.Id', '=', 'MapItem.T2LocationId')
                ->where('T2Location.Floor', '=', $floor) // Filter for Sub_Floor = 2
                ->select(
                    'SignageId as Sub_SignagesId',
                    'MapItemId as id',
                    'CadId as cadId',
                    'Longitudes',
                    'Latitudes',
                    'T2Location.Floor as Sub_Floor',
                )
                ->get()
                ->groupBy('Sub_SignagesId')
                ->map(function ($group) {
                    return [
                        'Sub_SignageMapCadId' => $group->map(function ($item) {
                            return [
                                'id' => $item['id'],
                                'cadId' => $item['cadId'],
                                'coordinates' => [$item['Longitudes'], $item['Latitudes']],
                                'Sub_Floor' => $item['Sub_Floor']
                            ];
                        })->values()->toArray()
                    ];
                })
                ->values()
                ->toArray();

            if (!empty($subSignages)) {
                if (!isset($result[$gId])) {
                    $result[$gId] = [
                        'G_Id' => $gId,
                        'G_Name' => $item['G_Name'] ?? 'Unknown',
                        'G_LanguageId' => $item['G_LanguageId'],
                        'G_IconUrl'=> $item['G_IconUrl'],
                        'Sub_F' => []
                    ];
                }

                $result[$gId]['Sub_F'][] = [
                    'Sub_Id' => $item['Sub_Id'],
                    'Sub_Name' => $item['Sub_Name'] ?? 'Unknown',
                    'Sub_IconUrl'=> $item['Sub_IconUrl'],
                    'Sub_LanguageId' => $item['Sub_LanguageId'],
                    'Sub_SignagesId' => $subSignages,
                    
                ];
            }
        }
    }

    // Remove any G-Id groups that ended up empty
    $result = array_filter($result, function($group) {
        return !empty($group['Sub_F']);
    });

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
