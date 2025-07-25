<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemTitle;


class FaqType extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'FaqType';
    public $primaryKey = 'Id';
    // Add fields that can be mass-assigned
    protected $fillable = ['TitleId', 'CreatedDate', 'ModifiDate','Status','UserId','OrderIndex']; // Example fields
    public $timestamps = false;

    public function title()
    {
        return $this->belongsTo(ItemTitle::class, 'TitleId', 'Id');
    }

    function getAllFaqType(){
        // $Language =  FaqTypeFaqTypeMapItem::All();
        $data =  FaqType::where('FaqType.Status', '!=', DELETED_FLG)
                    ->with('title.textcontent')
                    ->get();
        //dd($data);
        return $data;
    }

    function insertFaqType($data){
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return FaqType::insertGetId($data);
    }
    function updateFaqType($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return FaqType::where('Id', $id)->update($data->toArray());
    }

    function deletdFaqType($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return FaqType::where('Id', $id)->update($data->toArray());
    }

    function getFaqTypeById($id){
        $return = FaqType::where('Id', $id)->first();
        return $return;
    }
}
