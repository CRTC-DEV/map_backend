<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TextContent;
use App\Models\Map\MapItem;

class ItemDescription extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'ItemDescription';

    // Add fields that can be mass-assigned
    protected $fillable = ['TextcontentId', 'Status', 'CreatedDate', 'ModifiDate', 'UserId']; // Example fields
    public $timestamps = false;

    public function textcontent()
    {
        return $this->belongsTo(TextContent::class, 'TextContentId', 'Id');
    }
    function getAllItem()
    {

        $item_title =  ItemDescription::where('ItemDescription.Status', '!=', DELETED_FLG)
            ->join('TextContent', 'TextContent.Id', '=', 'TextcontentId')
            ->select(
                'ItemDescription.*',
                'TextContent.OriginalText as OriginalText',
                'TextContent.OriginalLanguageId as OriginalLanguageId'
            )
            ->get();
        // $map_items =  ItemType::All();
        return $item_title;
    }

    function insertItem($data)
    {
        //dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);

        $data['CreatedDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        // dd($data);
        return ItemDescription::insertGetId($data);
    }
    function updateItem($data, $id)
    {

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        return ItemDescription::where('Id', $id)->update($data->toArray());
    }

    function deleteItem($id)
    {
        return ItemDescription::where('Id', $id)->update(['Status' => DELETED_FLG]);
    }

    function getItemById($id)
    {
        $return = ItemDescription::where('Id', $id)->first();
        return $return;
    }
    function getAllItemsDescriptionWithTextContent()
    {
        $return = ItemDescription::join('TextContent', 'TextContent.Id', '=', 'TextcontentId')
            ->where('ItemDescription.Status', '!=', DELETED_FLG)
            ->select('ItemDescription.*', 'TextContent.OriginalText as OriginalText', 'TextContent.OriginalLanguageId as OriginalLanguageId')->orderBy('ItemDescription.Id', 'DESC')->get();

        return $return;
    }

    //for API


    function getItemDescription()
    {
        $data = MapItem::where('MapItem.Status', '!=', DELETED_FLG)
            // Filter by MapItem.Id
            //->where('T2Location.Floor', $floor)
            // Join with T2Location by T2LocationId
            ->join('T2Location', 'T2Location.Id', '=', 'MapItem.T2LocationId')
            // Join with ItemTitle by TitleId
            //->join('ItemTitle', 'ItemTitle.Id', '=', 'MapItem.TitleId')
            // Join with ItemDescription by DescriptionId
            ->join('ItemDescription', 'ItemDescription.Id', '=', 'MapItem.DescriptionId')
            // Join with TextContent for ItemTitle
            //->join('TextContent as TitleText', 'TitleText.Id', '=', 'ItemTitle.TextcontentId')
            // Join with TextContent for ItemDescription
            ->join('TextContent as TextContent', 'TextContent.Id', '=', 'ItemDescription.TextcontentId')
            //Join with ItemType
            ->join('ItemType', 'ItemType.Id', '=', 'MapItem.ItemTypeId')
            ->join('Translations', 'TextContent.id', '=', 'Translations.TextContentId')
            ->join('Languages', 'Translations.LanguageId', '=', 'Languages.Id')
            // Select necessary columns from the joined tables
            ->select(
                'MapItem.*',
                'T2Location.Zone',
                'T2Location.Floor',
                'T2Location.Name as LocationName',
                'T2Location.Id as LocationId',
                'TextContent.OriginalText as DescriptionText',
                'ItemType.IsShow as ItemTypeIsShow',
                'ItemDescription.Id as ItemDescriptionId',
                'TextContent.OriginalText as TextContentOriginalText',
                'Translations.Translation as Translation',
                'Languages.Name as LanguageName',
                'Languages.Id as LanguageId'
            )




            ->get(); // Use first() instead of get() since you're expecting only one item based on Id
        return $data;
    }

    function getItemDescriptionAPI($catid, $languageid, $floor)
    {
        $data = MapItem::where('MapItem.Status', '!=', DELETED_FLG)
            ->join('T2Location', 'T2Location.Id', '=', 'MapItem.T2LocationId')
            ->join('ItemDescription', 'ItemDescription.Id', '=', 'MapItem.DescriptionId')
            ->join('TextContent as TextContent', 'TextContent.Id', '=', 'ItemDescription.TextcontentId')
            ->join('ItemType', 'ItemType.Id', '=', 'MapItem.ItemTypeId')
            ->join('Translations', 'TextContent.id', '=', 'Translations.TextContentId')
            ->join('Languages', 'Translations.LanguageId', '=', 'Languages.Id')
            ->select(
                'MapItem.*',
                'T2Location.Zone',
                'T2Location.Floor',
                'T2Location.Name as LocationName',
                'T2Location.Id as LocationId',
                'TextContent.OriginalText as DescriptionText',
                'ItemType.IsShow as ItemTypeIsShow',
                'ItemDescription.Id as ItemDescriptionId',
                'TextContent.OriginalText as TextContentOriginalText',
                'Translations.Translation as Translation',
                'Languages.Name as LanguageName',
                'Languages.Id as LanguageId'
            )

            ->where('MapItem.CadId', '=', $catid)
            ->where('Languages.id', '=', $languageid)
            ->where('T2Location.Floor', '=', $floor)

            ->first(); // Use first() instead of get() since you're expecting only one item based on Id
        //return $data;

        return response()->json($data);
    }



    function getItemDescriptionAPI2($id, $languageid)
    {
        $return = TextContent::join('ItemTitle', 'TextContent.id', '=', 'ItemTitle.TextContentId')
            ->join('MapItem', 'MapItem.TitleId', '=', 'ItemTitle.Id')
            ->join('ItemDescription', 'MapItem.DescriptionId', '=', 'ItemDescription.Id')
            ->join('Translations', 'TextContent.id', '=', 'Translations.TextContentId')
            ->join('Languages', 'Translations.LanguageId', '=', 'Languages.Id')
            ->select('Translations.Translation', 'MapItem.CadId', 'Languages.Name', 'Translations.Translation')
            ->where('MapItem.CadId', '=', $id)
            ->where('Languages.id', '=', $languageid)
            ->first();

        return $return;
    }

    //test show all item description
    function getItemDescriptionAll()
    {
        $return = ItemDescription::all();
        return $return;
    }
}
