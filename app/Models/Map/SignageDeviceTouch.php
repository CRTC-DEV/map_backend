<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use App\Models\Map\Signages;
use App\Models\Map\DeviceTouchScreen;

class SignageDeviceTouch extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'SignageDeviceTouch';
    public $incrementing = false; // Không tự tăng
    protected $primaryKey = 'SignageId';

    // Add fields that can be mass-assigned
    protected $fillable = ['SignageId', 'DeviceTouchScreenId', 'CreatedDate', 'ModifiDate', 'UserId', 'Status', 'OrderIndex']; // Example fields
    public $timestamps = false;

    public function signage()
    {
        return $this->belongsTo(Signages::class, 'SignageId', 'Id');
    }

    public function deviceTouchScreen()
    {
        return $this->belongsTo(DeviceTouchScreen::class, 'DeviceTouchScreenId', 'Id');
    }

    function getAllSignageDeviceTouch()
    {

        // $data =  SignageDeviceTouch::where('SignageDeviceTouch.Status', '!=', DELETED_FLG)
        //             ->join('Signages','Signages.Id','=','SignageId')
        //             ->join('DeviceTouchScreen', 'DeviceTouchScreen.Id', '=','DeviceTouchScreenId')
        //             ->join('ItemTitle', 'ItemTitle.Id','=','Signages.TitleId')
        //             ->join('TextContent', 'TextContent.Id', '=','ItemTitle.TextContentId')
        //             ->select('SignageDeviceTouch.*', 'TextContent.OriginalText as title','DeviceTouchScreen.DeviceCode as DeviceCode')
        //             ->get();

        $data =  SignageDeviceTouch::where('SignageDeviceTouch.Status', '!=', DELETED_FLG)
            ->with([
                'signage.title.textcontent', // Load quan hệ `itemTitle` từ `signage`
                'deviceTouchScreen.t2location' // Load quan hệ `deviceTouchScreen`
            ])->get();

        // dd($data->toArray());
        return $data;
    }

    function insertSignageDeviceTouch($data)
    {
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return SignageDeviceTouch::insertGetId($data);
    }
    function updateSignageDeviceTouch($data, $id)
    {

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return SignageDeviceTouch::where('Id', $id)->update($data->toArray());
    }

    function deletdSignageDeviceTouch($data, $id)
    {

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return SignageDeviceTouch::where('Id', $id)->update($data->toArray());
    }

    function getSignageDeviceTouchById($SignageId, $DeviceTouchScreenId)
    {
        $return = SignageDeviceTouch::where('SignageId', $SignageId)
            ->where('DeviceTouchScreenId', $DeviceTouchScreenId)->first();
        return $return;
    }

    //For API

    function getAllSignageDeviceTouchAPI()
    {
        $data =  SignageDeviceTouch::where('SignageDeviceTouch.Status', '!=', DELETED_FLG)
            ->join('Signages', 'Signages.Id', '=', 'SignageId')
            ->join('DeviceTouchScreen', 'DeviceTouchScreen.Id', '=', 'DeviceTouchScreenId')
            ->join('ItemTitle', 'ItemTitle.Id', '=', 'Signages.TitleId')
            ->join('TextContent', 'TextContent.Id', '=', 'ItemTitle.TextContentId')
            ->join('Translations', 'Translations.TextContentId', '=', 'TextContent.Id')
            ->join('Languages', 'Languages.Id', '=', 'Translations.LanguageId')
            ->select(
                'DeviceTouchScreen.Id as DeviceId',
                'DeviceTouchScreen.DeviceCode as DeviceCode',
                'Signages.Id as SignageId',
                'Signages.IconUrl',
                'Signages.Description',
                'Signages.MapUrl',
                'Signages.BackgroundUrl',
                'Translations.Translation as Translation',
                'Languages.Id as LanguageId',
                'Languages.Name as LanguageName',
            )
            ->get();
        return $data;
    }
    function getSignageDeviceTouchAPI($DeviceId, $LanguageId)
    {
        $data =  SignageDeviceTouch::where('SignageDeviceTouch.Status', '!=', DELETED_FLG)
            ->where('DeviceTouchScreenId', $DeviceId)
            ->where('Languages.Id', $LanguageId)
            ->join('Signages', 'Signages.Id', '=', 'SignageId')
            ->join('DeviceTouchScreen', 'DeviceTouchScreen.Id', '=', 'DeviceTouchScreenId')
            ->join('ItemTitle', 'ItemTitle.Id', '=', 'Signages.TitleId')
            ->join('TextContent', 'TextContent.Id', '=', 'ItemTitle.TextContentId')
            ->join('Translations', 'Translations.TextContentId', '=', 'TextContent.Id')
            ->join('Languages', 'Languages.Id', '=', 'Translations.LanguageId')
            ->select(
                'DeviceTouchScreen.Id as DeviceId',
                'DeviceTouchScreen.DeviceCode as DeviceCode',
                'Signages.Id as SignageId',
                'Signages.IconUrl',
                'Signages.Description',
                'Signages.MapUrl',
                'Signages.BackgroundUrl',
                'Translations.Translation as Translation',
                'Languages.Id as LanguageId',
                'Languages.Name as LanguageName',
            )
            ->get();
        return $data;
    }
}
