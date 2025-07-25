<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use App\Models\Map\BannerAdv;
use App\Models\Map\DeviceTouchScreen;

class BannerAdvDeviceTouch extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'BannerAdvDeviceTouch';
    public $incrementing = false; // Không tự tăng
    public $primaryKey = 'BanneradvId';
    public $banner_adv_device_touch;

    // Add fields that can be mass-assigned
    protected $fillable = [
        'BanneradvId',
        'DeviceTouchScreenId',
        'Priority',
        'Status',
        'CreatedDate',
        'ModifiDate',
        'UserId'
    ];
    public $timestamps = false;

    public function banneradv()
    {
        return $this->belongsTo(BannerAdv::class, 'BanneradvId', 'Id');
    }

    public function devicetouch()
    {
        return $this->belongsTo(DeviceTouchScreen::class, 'DeviceTouchScreenId', 'Id');
    }
    function getAllItems(){

        $banner_adv_device_touch =  BannerAdvDeviceTouch::where('Status', '!=', DELETED_FLG)
            ->with('banneradv.title.textcontent','banneradv.description.textcontent','devicetouch')
            ->orderBy('BanneradvId','DESC')->get();
        
        return $banner_adv_device_touch;
    }

    function getItemById($banneradv_id, $devicetouch_id)
    {
        $return = BannerAdvDeviceTouch::where('BannerAdvDeviceTouch.Status', '!=', DELETED_FLG)
        ->where('BannerAdvDeviceTouch.BannerAdvId', $banneradv_id)
        ->where('BannerAdvDeviceTouch.DeviceTouchScreenId', $devicetouch_id)
        ->join('BannerAdv', 'BannerAdv.Id', '=', 'BannerAdvDeviceTouch.BanneradvId')
        ->join('DeviceTouchScreen', 'DeviceTouchScreen.Id', '=', 'BannerAdvDeviceTouch.DeviceTouchScreenId')
        ->join('ItemTitle', 'ItemTitle.Id', '=', 'BannerAdv.TitleId')
        // Join với ItemDescription bằng DescriptionId
        ->join('ItemDescription', 'ItemDescription.Id', '=', 'BannerAdv.DescriptionId')
        // Join với TextContent cho ItemTitle
        ->join('TextContent as TitleText', 'TitleText.Id', '=', 'ItemTitle.TextcontentId')
        // Join với TextContent cho ItemDescription
        ->join('TextContent as DescriptionText', 'DescriptionText.Id', '=', 'ItemDescription.TextcontentId')
        ->select(
            'BannerAdvDeviceTouch.*',
            'DescriptionText.OriginalText as DecriptionText',
            'TitleText.OriginalText as TitleText'

        )       
        ->first();
        
        return $return;
    }

    function getAllItemsWithTitle()
    {
        $return = BannerAdvDeviceTouch::where('BannerAdvDeviceTouch.Status', '!=', DELETED_FLG)
            ->join('BannerAdv', 'BannerAdv.Id', '=', 'BannerAdvDeviceTouch.BanneradvId')
            ->join('DeviceTouchScreen', 'DeviceTouchScreen.Id', '=', 'BannerAdvDeviceTouch.DeviceTouchScreenId')
            ->join('ItemTitle', 'ItemTitle.Id', '=', 'BannerAdv.TitleId')
            // Join với ItemDescription bằng DescriptionId
            ->join('ItemDescription', 'ItemDescription.Id', '=', 'BannerAdv.DescriptionId')
            // Join với TextContent cho ItemTitle
            ->join('TextContent as TitleText', 'TitleText.Id', '=', 'ItemTitle.TextcontentId')
            // Join với TextContent cho ItemDescription
            ->join('TextContent as DescriptionText', 'DescriptionText.Id', '=', 'ItemDescription.TextcontentId')
            ->select(
                'BannerAdvDeviceTouch.*',
                'DescriptionText.OriginalText as DecriptionText',
                'TitleText.OriginalText as TitleText'

            )
            ->orderBy('BannerAdv.Id', 'DESC')
            ->get();


        //dd($return);  
        return $return;
    }



    function insertItem($data)
    {
        // Convert Eloquent Collection to array if necessary
       //dd(is_array($data));
        
        //var_dump($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        //dd($data);
        return BannerAdvDeviceTouch::insertGetId($data);
    }

    
    function updateItem($data, $banneradv_id, $devicetouch_id){    

        $return = BannerAdvDeviceTouch::where('BanneradvId', $banneradv_id)
            ->where('DeviceTouchScreenId', $devicetouch_id);
        
        return  $return->update($data->toArray());
    }
}
