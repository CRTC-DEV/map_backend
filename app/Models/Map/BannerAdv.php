<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemTitle;
use App\Models\ItemDescription;

class BannerAdv extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'BannerAdv';

    // Add fields that can be mass-assigned
    protected $fillable = [ 'T2LocationId', 'TitleId', 'DescriptionId', 'CreatedDate', 'ModifiDate','UserId','Status','StartDate','ExpiryDate','ImagePathName1','ImagePathName2','ImagePathName3','LinkURL']; // Example fields
    public $timestamps = false;

    public function title()
    {
        return $this->belongsTo(ItemTitle::class, 'TitleId', 'Id');
    }
    public function description()
    {
        return $this->belongsTo(ItemDescription::class, 'DescriptionId', 'Id');
    }

    function getAllBannerAdv(){
        // $Language =  BannerAdvBannerAdvMapItem::All();
        $data =  BannerAdv::where('BannerAdv.Status', '!=', DELETED_FLG)
                    ->join('T2Location','T2Location.Id','=','T2LocationId')
                    ->join('ItemTitle', 'ItemTitle.Id', '=','TitleId')
                    ->join('TextContent', 'TextContent.Id', '=','ItemTitle.TextContentId')
                    ->select('BannerAdv.*', 'TextContent.OriginalText as title','T2Location.Name as T2locationName')
                    ->get();
        //dd($data);
        return $data;
    }

    function insertBannerAdv($data){
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return BannerAdv::insertGetId($data);
    }
    function updateBannerAdv($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return BannerAdv::where('Id', $id)->update($data->toArray());
    }

    function deletdBannerAdv($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return BannerAdv::where('Id', $id)->update($data->toArray());
    }

    function getBannerAdvById($id){
        $return = BannerAdv::where('Id', $id)->first();
        return $return;
    }
}
