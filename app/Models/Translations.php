<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Translations extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'Translations';
    public $incrementing = false; // Không tự tăng
    protected $primaryKey = 'TextContentId'; // Đặt khóa chính là mảng

    // Add fields that can be mass-assigned
    protected $fillable = [ 'TextContentId', 'LanguageId', 'Status', 'CreatedDate', 'ModifiDate', 'UserId','Translation']; // Example fields
    public $timestamps = false;

    function getAllTranslations(){
        // $Language =  TranslationsTranslationsMapItem::All();
        $data =  Translations::join('TextContent','TextContent.Id','=', 'Translations.TextContentId')
        ->join('Languages','Languages.Id','=', 'Translations.LanguageId')
        ->where('Translations.Status', '!=', DELETED_FLG)
        ->select('Translations.*',
                'TextContent.OriginalText as OriginalText',
                'Languages.Name as Name','Languages.Id as LanguageId')
        ->get();
        return $data;
    }

    function insertTranslations($data){
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return Translations::insertGetId($data);
    }
    function updateTranslations($data, $TextContentId, $LanguageId){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        $return = Translations::where('TextContentId', $TextContentId)
            ->where('LanguageId', $LanguageId);

        return  $return->update($data->toArray());
    }
    function deleteTranslations($data, $TextContentId, $LanguageId){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        $return = Translations::where('TextContentId', $TextContentId)
            ->where('LanguageId', $LanguageId);

        return $return->update($data);
    }

    function getTranslationsById($TextContentId, $LanguageId){
        $return = Translations::where('TextContentId', $TextContentId)
            ->where('LanguageId', $LanguageId)
            ->where('Translations.Status', '!=', DELETED_FLG)
            ->join('TextContent','TextContent.Id','=', 'Translations.TextContentId')
            ->join('Languages','Languages.Id','=', 'Translations.LanguageId')
            ->select('Translations.*',
            'TextContent.OriginalText as OriginalText',
            'Languages.Name as Name','Languages.Id as LanguageId')
            ->first();

        return $return;
    }
    function getTranslationsBy2Id($TextContentId, $LanguageId){
        $return = Translations::where('TextContentId', $TextContentId)
            ->where('LanguageId', $LanguageId)
            ->where('Translations.Status', '!=', DELETED_FLG)
            // ->join('TextContent','TextContent.Id','=', 'Translations.TextContentId')
            // ->join('Languages','Languages.Id','=', 'Translations.LanguageId')
            // ->select('Translations.*',
            // 'TextContent.OriginalText as OriginalText',
            // 'Languages.Name as Name','Languages.Id as LanguageId')
            ->first();

        return $return;
    }
    function getTranslationByTextContentId($TextContentId){

        $return = Translations::where('TextContentId', $TextContentId)
            ->where('Translations.Status', '!=', DELETED_FLG)
            ->join('TextContent','TextContent.Id','=', 'Translations.TextContentId')
            ->join('Languages','Languages.Id','=', 'Translations.LanguageId')
            ->select('Translations.*',
                'TextContent.OriginalText as OriginalText', 'Languages.Name as Name')
            ->get();

        return $return;
    }
    //for API
    function getTranslationsAPI($id, $languageId){
        $return = TextContent::join('translations', 'text_content.id', '=', 'translations.text_content_id')
            ->join('languages', 'translations.language_id', '=', 'languages.id')
            ->join('map_items', 'map_items.title_id', '=', 'item_titles.id')  // Assuming model is 'map_items'
            ->join('item_titles', 'text_content.id', '=', 'item_titles.text_content_id')
            ->join('item_descriptions', 'map_items.description_id', '=', 'item_descriptions.id')
            ->select('translations.translation', 'map_items.CadId', 'languages.name', 'translations.translation')
            ->get();
        return $return;
    }   

}
