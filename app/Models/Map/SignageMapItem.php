<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class SignageMapItem extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'SignageMapItem';
    public $incrementing = false; // Không tự tăng
    protected $primaryKey = 'SignageId';

    // Add fields that can be mass-assigned
    protected $fillable = [ 'SignageId', 'MapItemId', 'CreatedDate', 'ModifiDate','UserId','Status']; // Example fields
    public $timestamps = false;

    public function signage()
    {
        return $this->belongsTo(Signages::class, 'SignageId', 'Id');
    }

    public function mapitem()
    {
        return $this->belongsTo(MapItem::class, 'MapItemId', 'Id');
    }

    function getAllSignageMapItem(){       

        $data =  SignageMapItem::where('SignageMapItem.Status', '!=', DELETED_FLG)
                ->with([
                    'signage.title.textcontent', // Load quan hệ `itemTitle` từ `signage`
                    'mapitem' // Load quan hệ `deviceTouch`
                ])->get();
        
        // dd($data->toArray(),$data1->toArray(),$data2->toArray());
        return $data;
    }

    function insertSignageMapItem($data){
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return SignageMapItem::insertGetId($data);
    }
    function updateSignageMapItem($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return SignageMapItem::where('Id', $id)->update($data->toArray());
    }

    function deletdSignageMapItem($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return SignageMapItem::where('Id', $id)->update($data->toArray());
    }

    function getSignageMapItemById($SignageId,$MapItemId){
        $return = SignageMapItem::where('SignageId', $SignageId)
            ->where('MapItemId',$MapItemId)->first();
        return $return;
    }

    //For API
    function getSignageMapItem($floor,$signagetitle,$languageid){
      
        $return =  SignageMapItem::where('SignageMapItem.Status', '!=', DELETED_FLG)
                    ->join('Signages','Signages.Id','=','SignageId')
                    ->join('MapItem', 'MapItem.Id', '=','MapItemId')
                    ->join('T2Location', 'MapItem.T2LocationId', '=','T2Location.Id')
                    ->join('ItemTitle', 'ItemTitle.Id','=','Signages.TitleId')
                    ->join('ItemType', 'ItemType.Id','=','Signages.TitleId')
                    ->join('TextContent', 'TextContent.Id', '=','ItemTitle.TextContentId')
                    ->join('Translations', 'Translations.TextContentId', '=','TextContent.Id')
                    ->join('Languages', 'Languages.Id','=','Translations.LanguageId')
                    ->select('T2Location.Floor','ItemType.Name as SignageTitle'
                    ,'MapItem.CadId as MapItem','MapItem.Longitudes','MapItem.Latitudes','Languages.Id  as LanguageId'  ,'Languages.Name as LanguageName')
                    ->where('T2Location.Floor', '=', $floor)
                    ->where('ItemType.Name', '=', DB::raw("'$signagetitle'"))
                    ->where('Languages.Id', '=', $languageid)
                    ->get();
        //dd($return);
        return $return;
    }
}
