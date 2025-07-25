<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;


class T2Location extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'T2Location';

    // Add fields that can be mass-assigned
    protected $fillable = [ 'Zone', 'Floor', 'Status', 'CreatedDate', 'ModifiDate', 'Name']; // Example fields
    public $timestamps = false;

    function getAllT2Location(){
        // $Language =  T2LocationT2LocationMapItem::All();
        $data =  T2Location::where('Status', '!=', DELETED_FLG)
                    ->orderBy('Id', 'DESC')
                    ->get();
        return $data;
    }

    function insertT2Location($data){

        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        return T2Location::insertGetId($data);
    }
    function updateT2Location($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        return T2Location::where('Id', $id)->update($data->toArray());
    }
    function deleteT2Location($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        return T2Location::where('Id', $id)->update($data);
    }

    function getT2LocationById($id){
        $return = T2Location::where('Id', $id)->first();
        return $return;
    }
}
