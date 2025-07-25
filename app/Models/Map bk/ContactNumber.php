<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;


class ContactNumber extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'ContactNumber';
    public $primaryKey = 'Id';
    // Add fields that can be mass-assigned
    protected $fillable = [ 'CreatedDate', 'ModifiDate','UserId','Status','ContactNumberTypeId','NameId','PhoneNumberId','TerminalId'];
    public $timestamps = false;

    public function contactnumbertype()
    {
        return $this->belongsTo(ContactNumberType::class, 'ContactNumberTypeId', 'Id');
    }

    function getAllContactNumber(){
        // $Language =  ContactNumberContactNumberMapItem::All();
        $data =  ContactNumber::where('ContactNumber.Status', '!=', DELETED_FLG)
                    ->with('contactnumbertype.title.textcontent')
                    ->get();
        //dd($data);
        return $data;
    }

    function insertContactNumber($data){
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return ContactNumber::insertGetId($data);
    }
    function updateContactNumber($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return ContactNumber::where('Id', $id)->update($data->toArray());
    }

    function deletdContactNumber($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return ContactNumber::where('Id', $id)->update($data->toArray());
    }

    function getContactNumberById($id){
        $return = ContactNumber::where('Id', $id)->first();
        return $return;
    }
}
