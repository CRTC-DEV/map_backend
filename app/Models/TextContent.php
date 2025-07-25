<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TextContent extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'TextContent';
    protected $primaryKey = 'Id';
    // Add fields that can be mass-assigned
    protected $fillable = [ 'OriginalText', 'OriginalLanguageId', 'Status', 'CreatedDate', 'ModifiDate', 'UserId','Flg']; // Example fields
    public $timestamps = false;

    function getAllTextContent(){
        // $Language =  TextContentTextContentMapItem::All();
        $data =  TextContent::where('Status', '!=', DELETED_FLG)
                ->orderBy('Id', 'DESC')
                ->get();
        return $data;
    }
    function getAllTextContentWithLanguages(){
        // $Language =  TextContentTextContentMapItem::All();
        $data =  TextContent::where('TextContent.Status', '!=', DELETED_FLG)
            ->join('Languages', 'Languages.Id','=','OriginalLanguageId')
            ->select('TextContent.*', 'Languages.Name as LanguageName')->get();
        return $data;
    }
    function getTextContentForTitle(){
        $data =  TextContent::where('Status', '!=', DELETED_FLG)
            ->where('Flg','!=', TEXT_DESCRIPTION )
            ->orderBy('Id','DESC')->get();

        return $data;
    }

    function getTextContentForDescription(){
        $data =  TextContent::where('Status', '!=', DELETED_FLG)
            ->where('Flg','!=', TEXT_TITLE )
            ->orderBy('Id','DESC')->get();

        return $data;
    }
    function insertTextContent($data){

        $data['UserId'] =  auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        // dd($data);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return TextContent::insertGetId($data);
    }
    function updateTextContent($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        return TextContent::where('Id', $id)->update($data->toArray());
    }
    function deleteTextContent($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        return TextContent::where('Id', $id)->update($data);
    }

    function getTextContentById($id){
        $return = TextContent::where('Id', $id)->first();
        return $return;
    }

    function getLatedTextContentForTitle(){
        $return = TextContent::where('Flg','!=', TEXT_DESCRIPTION)
        ->orderBy('Id','DESC')->first();
        return $return;
    }
    function getLatedTextContentForDescription(){
        $return = TextContent::where('Flg','!=', TEXT_TITLE)
        ->orderBy('Id','DESC')->first();
        return $return;
    }
}
