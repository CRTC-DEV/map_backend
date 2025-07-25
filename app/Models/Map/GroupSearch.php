<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;

class GroupSearch extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'GroupSearch';

    // Add fields that can be mass-assigned
    protected $fillable = ['Name',
    'KeySearch', 'Priority',
    'Description','TitleId', 'Status', 'CreatedDate','ModifiDate','UserId','Rank'];     
    public $timestamps = false;
    function getAllItems(){

        //$item_title =  GroupSearch::where('Status', '!=', DELETED_FLG)->get();
        // $map_items =  ItemType::All();
        //return $item_title;
        return self::where('Status', '!=', DELETED_FLG)->get();

    }

    function insertItem($data){
        //dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);

        $data['CreatedDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        // dd($data);
        return GroupSearch::insertGetId($data);
    }
    function updateItem($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        return GroupSearch::where('Id', $id)->update($data->toArray());
    }

    function deleteItem($id){
        return GroupSearch::where('Id', $id)->update(['Status' => DELETED_FLG]);
    }

    function getItemById($id){
        $return = GroupSearch::where('Id', $id)->first();
        return $return;
    }

    
    


    
}
