<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Languages extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'Languages';

    // Add fields that can be mass-assigned
    protected $fillable = ['Name', 'Status', 'CreatedDate', 'ModifiDate','UserId']; // Example fields
    public $timestamps = false;

    function getAllLanguages(){
        $data =  Languages::where('Status','!=',DELETED_FLG)->get();
        return $data;
    }

    function insertLanguage($data){
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return Languages::insertGetId($data);
    }
    function updateLanguage($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        return Languages::where('Id', $id)->update($data->toArray());
    }
    function deleteLanguage($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        return Languages::where('Id', $id)->update($data);
    }

    function getLanguageById($id){
        $return = Languages::where('Id', $id)->first();
        return $return;
    }
}
