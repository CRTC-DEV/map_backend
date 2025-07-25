<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemTitle;


class Signages extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'Signages';
    protected $primaryKey = 'Id'; // Đặt khóa chính là 'Id'
    protected $fillable = [
        'CadId',
        'TitleId',
        'Longitudes',
        'Latitudes',
        'Status',
        'IconUrl',
        'Description',
        'BackgroundUrl',
        'MapUrl',
        'CreatedDate',
        'ModifiDate',
        'UserId',
        'Rank',
    ];
    public $timestamps = false;

    public function title()
    {
        return $this->belongsTo(ItemTitle::class, 'TitleId', 'Id');
    }

    function getAllSignages()
    {
        // $Language =  SignagesSignagesMapItem::All();
        $data =  Signages::where('Signages.Status', '!=', DELETED_FLG)
            // ->with('title.textcontent')
            ->join('ItemTitle', 'ItemTitle.Id', '=', 'Signages.TitleId')
            ->join('TextContent', 'TextContent.Id', '=', 'ItemTitle.TextContentId')
            ->select('Signages.*', 'TextContent.OriginalText as OriginalText')
            ->get();
        //dd($data);
        return $data;
    }

    function insertSignages($data)
    {
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return Signages::insertGetId($data);
    }
    function updateSignages($data, $id)
    {

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return Signages::where('Id', $id)->update($data->toArray());
    }

    function deletdSignages($data, $id)
    {

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return Signages::where('Id', $id)->update($data->toArray());
    }

    function getSignagesById($id)
    {
        $return = Signages::where('Id', $id)->first();
        return $return;
    }

    //For API
    function getSignageAPI($languageid = null)
    {
        // Set default language ID if not provided
        $languageid = $languageid ?? 5; // Assuming 1 is the ID for English
        $data =  Signages::where('Signages.Status', '!=', DELETED_FLG)
            ->where('Languages.Id', $languageid)
            ->join('ItemTitle', 'ItemTitle.Id', '=', 'Signages.TitleId')
            ->join('TextContent', 'TextContent.Id', '=', 'ItemTitle.TextContentId')
            ->join('Translations', 'Translations.TextContentId', '=', 'TextContent.Id')
            ->join('Languages', 'Languages.Id', '=', 'Translations.LanguageId')
            ->select(
                'Signages.Id',
                'Signages.IconUrl',
                'Signages.Description',
                'Signages.MapUrl',
                'Signages.BackgroundUrl',
                'Translations.Translation as Translation',
                'Languages.Name as LanguageName',
            )
            ->orderBy('Signages.Id','asc')
            ->get();
        //dd($data);
        return $data;
    }

    function getSignageAllAPI()
    {
        $data =  Signages::where('Signages.Status', '!=', DELETED_FLG)


            ->join('ItemTitle', 'ItemTitle.Id', '=', 'Signages.TitleId')
            ->join('TextContent', 'TextContent.Id', '=', 'ItemTitle.TextContentId')
            ->join('Translations', 'Translations.TextContentId', '=', 'TextContent.Id')
            ->join('Languages', 'Languages.Id', '=', 'TextContent.OriginalLanguageId')
            ->select(
                'Signages.Id',
                'Signages.IconUrl',
                'Signages.Description',
                'Signages.MapUrl',
                'Signages.BackgroundUrl',
                'Translations.Translation as Translation',
                'Languages.Name as LanguageName',                

            )
            ->get();
        //dd($data);
        return $data;
    }
}
