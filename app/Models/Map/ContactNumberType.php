<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemTitle;


class ContactNumberType extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'ContactNumberType';
    public $primaryKey = 'Id';
    // Add fields that can be mass-assigned
    protected $fillable = [  'TitleId', 'CreatedDate', 'ModifiDate','UserId','Status','OrderIndex',];
    public $timestamps = false;

    public function title()
    {
        return $this->belongsTo(ItemTitle::class, 'TitleId', 'Id');
    }

    function getAllContactNumberType(){
        // $Language =  ContactNumberTypeContactNumberTypeMapItem::All();
        $data =  ContactNumberType::where('ContactNumberType.Status', '!=', DELETED_FLG)
                    ->with('title.textcontent')
                    ->get();
        //dd($data);
        return $data;
    }

    function insertContactNumberType($data){
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return ContactNumberType::insertGetId($data);
    }
    function updateContactNumberType($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return ContactNumberType::where('Id', $id)->update($data->toArray());
    }

    function deletdContactNumberType($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return ContactNumberType::where('Id', $id)->update($data->toArray());
    }

    function getContactNumberTypeById($id){
        $return = ContactNumberType::where('Id', $id)->first();
        return $return;
    }
}
