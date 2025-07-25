<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemTitle;
use App\Models\Map\ItemType;


class MainFunction extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'MainFunction';
    protected $primaryKey = 'Id'; // Đặt khóa chính là 'Id'
    protected $fillable = [
       
        'TitleId',
        'Status',
        'IconUrl',
        'Link',
        'CreatedDate',
        'ModifiDate',
        'UserId',
        'Rank',
        'SignagesId',
    ];
    public $timestamps = false;

    public function title()
    {
        return $this->belongsTo(ItemTitle::class, 'TitleId', 'Id');
    }
    public function type()
    {
        return $this->belongsTo(ItemType::class, 'TitleId', 'Id');
    }

    function getAllFunction(){
        // $Language =  MainFunctionsMainFunctionsMapItem::All();
        $data =  MainFunction::where('MainFunction.Status', '!=', DELETED_FLG)
                    ->join('ItemTitle', 'ItemTitle.Id', '=', 'MainFunction.TitleId')
                    ->join('TextContent', 'TextContent.Id', '=', 'ItemTitle.TextContentId')
                    ->select('MainFunction.*', 'TextContent.OriginalText as OriginalText')
                    // ->with('type')
                    ->get();
        //dd($data);
        return $data;
    }

    function insertFunction($data){
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return MainFunction::insertGetId($data);
    }
    function updateFunction($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return MainFunction::where('Id', $id)->update($data->toArray());
    }

    function deletdFunction($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return MainFunction::where('Id', $id)->update($data->toArray());
    }

    function getFunctionById($id){
        $return = MainFunction::where('Id', $id)
        ->with('title.textcontent')->first();
        return $return;
    }
}
