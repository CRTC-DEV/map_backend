<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemTitle;


class GroupFunction extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'GroupFunction';
    protected $primaryKey = 'Id'; // Đặt khóa chính là 'Id'
    protected $fillable = [
       
        'TitleId',
        'Status',
        'IconUrl',
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
    public function type()
    {
        return $this->belongsTo(ItemType::class, 'TitleId', 'Id');
    }

    function getAllGroupFunctions(){
        // $Language =  GroupFunctionsGroupFunctionsMapItem::All();
        $data =  GroupFunction::where('GroupFunction.Status', '!=', DELETED_FLG)
                    ->with('title.textcontent')
                    // ->with('type')
                    ->get();
        return $data;
    }

    function insertGroupFunctions($data){
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return GroupFunction::insertGetId($data);
    }
    function updateGroupFunctions($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return GroupFunction::where('Id', $id)->update($data->toArray());
    }

    function deletdGroupFunctions($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return GroupFunction::where('Id', $id)->update($data->toArray());
    }

    function getGroupFunctionsById($id){
        $return = GroupFunction::where('Id', $id)->first();
        return $return;
    }
}
