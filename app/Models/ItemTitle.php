<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TextContent;
use App\Models\Map\MainFunction;

class ItemTitle extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'ItemTitle';

    // Add fields that can be mass-assigned
    protected $fillable = ['TextContentId', 'Status','IsShow', 'CreatedDate','ModifiDate','UserId','Type']; // Example fields
    public $timestamps = false;

    public function textcontent()
    {
        return $this->belongsTo(TextContent::class, 'TextContentId', 'Id');
    }

    function getAllItems(){

        $item_title =  ItemTitle::where('ItemTitle.Status', '!=', DELETED_FLG)
            ->join('TextContent','TextContent.Id','=','TextcontentId')
            ->select('ItemTitle.*', 
                'TextContent.OriginalText as OriginalText', 'TextContent.OriginalLanguageId as OriginalLanguageId')
                ->get();
        // $map_items =  ItemType::All();
        return $item_title;
    }

    function getItemsWithType($Type){
        $excludedIds = MainFunction::pluck('TitleId');
        //dd($excludedIds);
        $item_title =  ItemTitle::where('ItemTitle.Status', '!=', DELETED_FLG)
            ->where('ItemTitle.Type', $Type)
            ->whereNotIn('ItemTitle.Id', $excludedIds)
            ->join('TextContent','TextContent.Id','=','TextcontentId')
            ->select('ItemTitle.*', 
                'TextContent.OriginalText as OriginalText', 'TextContent.OriginalLanguageId as OriginalLanguageId')
                ->get();
        // $map_items =  ItemType::All();
        return $item_title;
    }

    function insertItem($data){
        //dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        
        $data['CreatedDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        // dd($data);
        return ItemTitle::insertGetId($data);
    }
    function updateItem($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        return ItemTitle::where('Id', $id)->update($data->toArray());
    }

    function deleteItem($id){
        return ItemTitle::where('Id', $id)->update(['Status' => DELETED_FLG]);
    }

    function getItemById($id){
        $return = ItemTitle::where('Id', $id)->first();
        return $return;
    }
    // function getItemByIdWithTextContent($id){
    //     $return = ItemTitle::where('Id', $id)
    //     ->where('ItemTitle.Status', '!=', DELETED_FLG)
    //     // ->where('ItemTitle.Type', $Type)
    //     // ->whereNotIn('ItemTitle.Id', $excludedIds)
    //     // ->join('TextContent','TextContent.Id','=','TextcontentId')
    //     // ->select('ItemTitle.*', 
    //     //     'TextContent.OriginalText as OriginalText', 'TextContent.OriginalLanguageId as OriginalLanguageId')
    //     ->which('TextContent','TextContent.Id','=','TextcontentId')
    //     ->first();
    //     return $return;
    // }
    function getAllItemsWithTextContent(){
        $return = ItemTitle::join('TextContent','TextContent.Id', '=' ,'TextcontentId')
            ->where('ItemTitle.Status','!=',DELETED_FLG)
            ->select('ItemTitle.*', 
            'TextContent.OriginalText as OriginalText', 'TextContent.OriginalLanguageId as OriginalLanguageId')
            ->orderBy('ItemTitle.Id','DESC')->get();
        // dd($return);
            // ->select('ItemTitle.*', 'TextContent.OriginalText as OriginalText', 'TextContent.OriginalLanguageId as OriginalLanguageId')->get();

        return $return;
    }
    // function textContent(){
    //     $this->belongsTo(TextContent::class,'TextContenId', 'Id');
    // }
    //for API
      

    function getItemTitle() {
        $return = TextContent::join('ItemTitle', 'TextContent.id', '=', 'ItemTitle.TextContentId')
            ->join('MapItem', 'MapItem.TitleId', '=', 'ItemTitle.Id')
            ->join('ItemTitle', 'MapItem.DescriptionId', '=', 'ItemTitle.Id')
            ->join('Translations', 'TextContent.id', '=', 'Translations.TextContentId')
            ->join('Languages', 'Translations.LanguageId', '=', 'Languages.Id')
            ->select('Translations.Translation', 'MapItem.CadId', 'Languages.Name', 'Translations.Translation')
            
            ->get();
            
        return $return;
    }

    function getItemTitleAPI($id, $languageid,$floorid){
        $return = TextContent::join('ItemTitle', 'TextContent.id', '=', 'ItemTitle.TextContentId')
            ->join('MapItem', 'MapItem.TitleId', '=', 'ItemTitle.Id')
            ->join('ItemTitle', 'MapItem.DescriptionId', '=', 'ItemTitle.Id')
            ->join('Translations', 'TextContent.id', '=', 'Translations.TextContentId')
            ->join('Languages', 'Translations.LanguageId', '=', 'Languages.Id')
            ->select('Translations.Translation', 'MapItem.CadId', 'Languages.Name', 'Translations.Translation')
            ->where('MapItem.CadId', '=', $id)
            ->where('Languages.id', '=', $languageid)
            ->first();
            
        return $return;
    }
}
