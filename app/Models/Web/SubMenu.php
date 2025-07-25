<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemTitle;


class SubMenu extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'SubMenu';
    public $primaryKey = 'Id';
    // Add fields that can be mass-assigned
    protected $fillable = [ 'CreatedDate', 'ModifiDate','UserId','Status','TitleId','Rank','OrderIndex'];
    public $timestamps = false;

    public function title()
    {
        return $this->belongsTo(ItemTitle::class, 'TitleId', 'Id');
    }

    function getAllSubMenu(){

        $data =  SubMenu::where('SubMenu.Status', '!=', DELETED_FLG)
                    ->with('title.textcontent')
                    ->get();
        //dd($data);
        return $data;
    }

    function getAllSubMenuById($id){

        $data =  SubMenu::where('SubMenu.Status', '!=', DELETED_FLG)
                    ->where('SubMenu.Id', $id)
                    ->with('title.textcontent')
                    ->first();
        //dd($data);
        return $data;
    }



    function insertSubMenu($data){
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return SubMenu::insertGetId($data);
    }
    function updateSubMenu($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return SubMenu::where('Id', $id)->update($data->toArray());
    }

    function deletdSubMenu($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return SubMenu::where('Id', $id)->update($data->toArray());
    }

    function getSubMenuById($id){
        $return = SubMenu::where('Id', $id)->first();
        return $return;
    }
}
