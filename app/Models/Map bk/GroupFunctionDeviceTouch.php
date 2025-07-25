<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
//use App\Models\Map\GroupFunction;
//use App\Models\Map\DeviceTouchScreen;


class GroupFunctionDeviceTouch extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'GroupFunctionDeviceTouch';
    public $incrementing = false; // Không tự tăng
    protected $keyType = 'string';
    protected $primaryKey = null;

    // Add fields that can be mass-assigned
    protected $fillable = ['GroupFunctionId', 'DeviceTouchScreenId', 'CreatedDate', 'ModifiDate', 'UserId', 'Status', 'OrderIndex']; // Example fields
    public $timestamps = false;

    public function groupfunction()
    {
        return $this->belongsTo(GroupFunction::class, 'GroupFunctionId', 'Id');
    }

    public function deviceTouchScreen()
    {
        return $this->belongsTo(DeviceTouchScreen::class, 'DeviceTouchScreenId', 'Id');
    }

    public function mainfunction()
    {
        return $this->belongsTo(MainFunction::class, 'Id', 'MainFunctionId');
    }

    function getAllGroupFunctionDeviceTouch()
    {


        $data =  GroupFunctionDeviceTouch::where('GroupFunctionDeviceTouch.Status', '!=', DELETED_FLG)
            ->with([
                'groupfunction.title.textcontent', // Load quan hệ `itemTitle` từ `signage`
                'deviceTouchScreen.t2location' // Load quan hệ `deviceTouchScreen`
            ])->get();

        // dd($data->toArray());
        return $data;
    }

    function insertGroupFunctionDeviceTouch($data)
    {
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return GroupFunctionDeviceTouch::insertGetId($data);
    }
    function updateGroupFunctionDeviceTouch($data, $id)
    {

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return GroupFunctionDeviceTouch::where('Id', $id)->update($data->toArray());
    }

    function deletdGroupFunctionDeviceTouch($data, $id)
    {

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return GroupFunctionDeviceTouch::where('Id', $id)->update($data->toArray());
    }

    function getGroupFunctionDeviceTouchById($SignageId, $DeviceTouchScreenId)
    {
        $return = GroupFunctionDeviceTouch::where('SignageId', $SignageId)
            ->where('DeviceTouchScreenId', $DeviceTouchScreenId)->first();
        return $return;
    }

    //For API
    function getGroupFunctionDeviceTouchAPI($DeviceId)
    {
        $return = GroupFunctionDeviceTouch::where('Id', $DeviceId)
            ->get();
        return $return;
    }

    function groupByGroupTranslations($data)
{
    return $data->groupBy('GroupTranslations')->map(function ($items, $groupTranslation) {
        // Gom các SubTranslations vào một object
        $subTranslationObject = $items->mapWithKeys(function ($item, $key) {
            return [
                $key => [
                    'SubLanguagesId' => $item->SubLanguagesId,
                    'SubLanguages' => $item->SubLanguages,
                    'SubTranslationsText' => $item->SubTranslations,
                    'SubFunctionIconUrl' => $item->SubFunctionIconUrl,
                    'SubFunctionLink' => $item->SubFunctionLink,

                ]
            ];
        });

        return [
            'DeviceId' => $items->first()->DeviceId,
            'GroupLanguagesId' => $items->first()->GroupLanguagesId,
            'GroupLanguages' => $items->first()->GroupLanguages,
            'GroupFunctionIconUrl' => $items->first()->GroupFunctionIconUrl,
            'GroupTranslations' => $groupTranslation,
            'SubTranslations' => $subTranslationObject,
        ];
    })->values();
}






    function getGroupMainFunctionDevice()
    {
        $results = DB::table('DeviceTouchScreen')
            ->join('T2Location', 'T2Location.Id', '=', 'DeviceTouchScreen.T2LocationId')
            ->join('GroupFunctionDeviceTouch', 'GroupFunctionDeviceTouch.DeviceTouchScreenId', '=', 'DeviceTouchScreen.Id')
            ->join('GroupMainFunction', 'GroupMainFunction.GroupFunctionId', '=', 'GroupFunctionDeviceTouch.GroupFunctionId')
            ->join('GroupFunction', 'GroupFunction.Id', '=', 'GroupMainFunction.GroupFunctionId')
            ->join('MainFunction', 'MainFunction.Id', '=', 'GroupMainFunction.MainFunctionId')
            //GroupFunction
            ->join('ItemTitle as GroupTitle', 'GroupTitle.Id', '=', 'GroupFunction.TitleId')
            //->join('TextContent as GroupText', 'GroupText.Id', '=', 'GroupTitle.TextcontentId')
            ->join('Translations as GroupTranslations', 'GroupTranslations.TextcontentId', '=', 'GroupTitle.TextcontentId')
            ->join('Languages as GroupLanguages', 'GroupLanguages.Id', '=', 'GroupTranslations.LanguageId')
            //SubFunction
            ->join('ItemTitle as FunctionTitle', 'FunctionTitle.Id', '=', 'MainFunction.TitleId') 
            ->join('TextContent as FunctionText', 'FunctionText.Id', '=', 'FunctionTitle.TextcontentId')
            //->join('Translations as SubTranslations', 'SubTranslations.TextcontentId', '=', 'FunctionText.Id')      
            ->join('Translations as SubTranslations', 'SubTranslations.TextcontentId', '=', 'FunctionTitle.TextcontentId')
            
           
            ->select(
                'DeviceTouchScreen.Id as DeviceId',
                'T2Location.Floor',
                'GroupFunction.Id as GroupFunctionId',
                'GroupFunction.IconUrl as GroupFunctionIconUrl',
                'GroupTranslations.Translation AS GroupTranslation',
                'GroupLanguages.Id as GroupLanguagesId',
                'GroupLanguages.Name as GroupLanguage',
                //SubFunction
                //'FunctionTitle.TextcontentId as SubFunctionTitleId',
                'MainFunction.TitleId as SubFunctionTitleId',

                DB::raw('GROUP_CONCAT(
            JSON_OBJECT(
                "MainFunctionId", MainFunction.Id,
                "MainFunctionTitle", MainFunction.TitleId,               
                "MainFunctionIconUrl", MainFunction.IconUrl,
                "MainFunctionTranslations", SubTranslations.Translation
                
            )
        ) as MainFunctions')
            )
            ->groupBy('DeviceTouchScreen.Id', 'T2Location.Floor', 'GroupFunction.Id', 'GroupFunction.IconUrl',
            'GroupTranslation','GroupLanguagesId', 'GroupLanguage','SubFunctionTitleId')
            ->get();
            //var_dump($results   );
        //return $this -> groupByGroupTranslations($results);
        return $results;
    }

    

    function getGroupMainFunctionDeviceAPI($DeviceId, $LanguageId)
    {
        $data = DeviceTouchScreen::where('DeviceTouchScreen.Status', '!=', DELETED_FLG)
            ->where('GroupLanguages.Id', $LanguageId)
            ->where('SubLanguages.Id', $LanguageId)
            ->where('DeviceTouchScreen.Id', $DeviceId)

            ->join('T2Location', 'T2Location.Id', '=', 'DeviceTouchScreen.T2LocationId')
            ->join('GroupFunctionDeviceTouch', 'GroupFunctionDeviceTouch.DeviceTouchScreenId', '=', 'DeviceTouchScreen.Id')
            ->join('GroupMainFunction', 'GroupMainFunction.GroupFunctionId', '=', 'GroupFunctionDeviceTouch.GroupFunctionId')
            ->join('GroupFunction', 'GroupFunction.Id', '=', 'GroupMainFunction.GroupFunctionId')
            ->join('MainFunction', 'MainFunction.Id', '=', 'GroupMainFunction.MainFunctionId')
            //GroupFunction
            ->join('ItemTitle as GroupTitle', 'GroupTitle.Id', '=', 'GroupFunction.TitleId')
            ->join('TextContent as GroupText', 'GroupText.Id', '=', 'GroupTitle.TextcontentId')
            ->join('Translations as GroupTranslations', 'GroupTranslations.TextcontentId', '=', 'GroupText.Id')
            ->join('Languages as GroupLanguages', 'GroupLanguages.Id', '=', 'GroupTranslations.LanguageId')
            //SubFunction 
            ->join('ItemTitle as FunctionTitle', 'FunctionTitle.Id', '=', 'MainFunction.TitleId')
            ->join('TextContent as FunctionText', 'FunctionText.Id', '=', 'FunctionTitle.TextcontentId')
            ->join('Translations as SubTranslations', 'SubTranslations.TextcontentId', '=', 'FunctionText.Id')
            ->join('Languages as SubLanguages', 'SubLanguages.Id', '=', 'SubTranslations.LanguageId')
            ->select(
                'DeviceTouchScreen.Id as DeviceId',
                'T2Location.Floor',
                'GroupLanguages.Id as GroupLanguagesId',
                'GroupLanguages.Name as GroupLanguages',
                'GroupFunction.IconUrl as GroupFunctionIconUrl',
                'GroupTranslations.Translation as GroupTranslations',


                'SubLanguages.Id as SubLanguagesId',
                'SubLanguages.Name as SubLanguages',
                'SubTranslations.Translation as SubTranslations',
                'MainFunction.IconUrl as SubFunctionIconUrl',
                'MainFunction.Link as SubFunctionLink'

            )
            ->get();

        // Xử lý dữ liệu để định dạng lại JSON
        //return $data;
        return $this->groupByGroupTranslations($data);
    }



    function getGroupMainFunctionDeviceById($DeviceId)
    {
        $data = DeviceTouchScreen::where('DeviceTouchScreen.Status', '!=', DELETED_FLG)
            // Filter by MapItem.Id
            ->where('DeviceTouchScreen.Id', $DeviceId)
            // Join with T2Location by T2LocationId
            ->join('T2Location', 'T2Location.Id', '=', 'DeviceTouchScreen.T2LocationId')
            //join with GroupFunctionDeviceTouch
            ->join('GroupFunctionDeviceTouch', 'GroupFunctionDeviceTouch.DeviceTouchScreenId', '=', 'DeviceTouchScreen.Id')
            //join with GroupMainFunction
            ->join('GroupMainFunction', 'GroupMainFunction.GroupFunctionId', '=', 'GroupFunctionDeviceTouch.GroupFunctionId')
            //join with GroupFunction
            ->join('GroupFunction', 'GroupFunction.Id', '=', 'GroupMainFunction.GroupFunctionId')
            //join with MainFunction
            ->join('MainFunction', 'MainFunction.Id', '=', 'GroupMainFunction.MainFunctionId')
            //join with ItemTitle
            ->join('ItemTitle as GroupTitle', 'GroupTitle.Id', '=', 'GroupFunction.TitleId')
            // Join with TextContent for ItemTitle
            ->join('TextContent as GroupText', 'GroupText.Id', '=', 'GroupTitle.TextcontentId')
            //join with ItemTitle
            ->join('ItemTitle as FunctionTitle', 'FunctionTitle.Id', '=', 'MainFunction.TitleId')
            // Join with TextContent for ItemTitle
            ->join('TextContent as FunctionText', 'FunctionText.Id', '=', 'FunctionTitle.TextcontentId')

            ->select(
                'DeviceTouchScreen.*',
                'T2Location.Floor',
                'GroupText.OriginalText as GroupFunction',
                'FunctionText.OriginalText as SubFunction',
                'MainFunction.IconUrl as IconUrl-SubFunction',

            )
            ->get(); // Use first() instead of get() since you're expecting only one item based on Id
        //dd($data);
        return $data;
    }
}
