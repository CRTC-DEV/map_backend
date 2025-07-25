<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'ItemType';

    // Add fields that can be mass-assigned
    protected $fillable = ['Name', 'Description', 'Status','IsShow', 'CreatedDate','ModifiDate','UserId']; // Example fields
    public $timestamps = false;
    function getAllItemTypes(){

        $item_types =  ItemType::where('Status', '!=', DELETED_FLG)
            ->orderBy('Id','DESC')->get();
        // $map_items =  ItemType::All();
        return $item_types;
    }

    function insertItemType($data){
        //dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);

        $data['CreatedDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        // dd($data);
        return ItemType::insertGetId($data);
    }
    function updateItemType($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        return ItemType::where('Id', $id)->update($data->toArray());
    }

    function deleteItemType($id){
        //dd($id);
        return ItemType::where('Id', $id)->update(['Status' => DELETED_FLG]);
    }

    function getItemTypeById($id){
        $return = ItemType::where('Id', $id)->first();
        return $return;
    }
}
