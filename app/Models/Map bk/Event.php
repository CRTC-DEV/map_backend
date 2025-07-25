<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemTitle;
use App\Models\ItemDescription;


class Event extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'Event';
    public $primaryKey = 'Id';
    // Add fields that can be mass-assigned
    protected $fillable = ['T2LocationId', 'TitleId', 'DescriptionId', 'CreatedDate', 'ModifiDate', 'UserId', 'Status', 'Longitudes', 'Latitudes', 'EventStatus', 'ImagePathName', 'Rank', 'LinkURL', 'GroupSearchId', 'ViewCount', 'PeriodFrom', 'PeriodTo'];
    public $timestamps = false;

    public function title()
    {
        return $this->belongsTo(ItemTitle::class, 'TitleId', 'Id');
    }
    public function description()
    {
        return $this->belongsTo(ItemDescription::class, 'DescriptionId', 'Id');
    }

    function getAllEvent()
    {
        // $Language =  EventEventMapItem::All();
        $data =  Event::where('Event.Status', '!=', DELETED_FLG)
            ->with('title.textcontent', 'description.textcontent')
            ->get();
        //dd($data);
        return $data;
    }

    function insertEvent($data)
    {
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return Event::insertGetId($data);
    }
    function updateEvent($data, $id)
    {

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return Event::where('Id', $id)->update($data->toArray());
    }

    function deletdEvent($data, $id)
    {

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return Event::where('Id', $id)->update($data->toArray());
    }

    function getEventById($id)
    {
        $return = Event::where('Id', $id)->first();
        return $return;
    }

    //for API

    function getEventAllAPI()
    {
        $data =  Event::where('Event.Status', '!=', DELETED_FLG)
            ->join('GroupSearch', 'Event.GroupSearchId', '=', 'GroupSearch.Id')
            //Join ItemTitle Translations
            ->join('ItemTitle', 'ItemTitle.Id', '=', 'Event.TitleId')
            ->join('TextContent as TitleTextContent', 'TitleTextContent.Id', '=', 'ItemTitle.TextContentId')
            ->join('Translations as TitleTranslations', 'TitleTranslations.TextContentId', '=', 'TitleTextContent.Id')
            ->join('Languages as TitleLanguages', 'TitleLanguages.Id', '=', 'TitleTranslations.LanguageId')
            //join DescriptionTitle Translations
            ->join('ItemDescription', 'ItemDescription.Id', '=', 'Event.DescriptionId')
            ->join('TextContent as DescriptionTextContent', 'DescriptionTextContent.Id', '=', 'ItemDescription.TextContentId')
            ->join('Translations as DescriptionTranslations', 'DescriptionTranslations.TextContentId', '=', 'DescriptionTextContent.Id')
            ->join('Languages as DescriptionLanguages', 'DescriptionLanguages.Id', '=', 'DescriptionTranslations.LanguageId')

            ->select(
                'Event.*',
                'GroupSearch.Name as GroupSearchName',
                'TitleTranslations.Translation as TitleTranslation',
                'TitleLanguages.Name as TitleLanguage',
                'DescriptionTranslations.Translation as DescriptionTranslation',
                'DescriptionLanguages.Name as DescriptionLanguage',

            )
            ->get();
        //dd($data);
        return $data;
    }

    function getEventByIdAPI($languageid)
    {
        $data =  Event::where('Event.Status', '!=', DELETED_FLG)
            ->where('TitleLanguages.Id', $languageid)
            ->where('DescriptionLanguages.Id', $languageid)

            ->join('GroupSearch', 'Event.GroupSearchId', '=', 'GroupSearch.Id')
            //Join ItemTitle Translations
            ->join('ItemTitle', 'ItemTitle.Id', '=', 'Event.TitleId')
            ->join('TextContent as TitleTextContent', 'TitleTextContent.Id', '=', 'ItemTitle.TextContentId')
            ->join('Translations as TitleTranslations', 'TitleTranslations.TextContentId', '=', 'TitleTextContent.Id')
            ->join('Languages as TitleLanguages', 'TitleLanguages.Id', '=', 'TitleTranslations.LanguageId')
            //join DescriptionTitle Translations
            ->join('ItemDescription', 'ItemDescription.Id', '=', 'Event.DescriptionId')
            ->join('TextContent as DescriptionTextContent', 'DescriptionTextContent.Id', '=', 'ItemDescription.TextContentId')
            ->join('Translations as DescriptionTranslations', 'DescriptionTranslations.TextContentId', '=', 'DescriptionTextContent.Id')
            ->join('Languages as DescriptionLanguages', 'DescriptionLanguages.Id', '=', 'DescriptionTranslations.LanguageId')

            ->select(
                'Event.*',
                'GroupSearch.Name as GroupSearchName',
                'TitleTranslations.Translation as TitleTranslation',
                'TitleLanguages.Name as TitleLanguage',
                'DescriptionTranslations.Translation as DescriptionTranslation',
                'DescriptionLanguages.Name as DescriptionLanguage',

            )
            ->get();
        //dd($data);
        return $data;
    }

    function updateCounterEventAPI($eventid)
    {
        return Event::where('Id', $eventid)->increment('ViewCount');
    }
}
