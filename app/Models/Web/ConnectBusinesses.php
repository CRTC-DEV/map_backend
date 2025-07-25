<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ConnectBusinesses extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'ConnectBusinesses';
    protected $primaryKey = 'id';

    // Add fields that can be mass-assigned
    protected $fillable = [ 'Title', 'Description', 'CreatedDate', 'ModifiDate','UserId','Status','Banner','File','SubMenuId']; // Example fields
    public $timestamps = false;
    public function submenu()
    {
        return $this->belongsTo(SubMenu::class, 'SubMenuId', 'Id');
    }

    function getAllConnectBusinesses(){       

        $data =  ConnectBusinesses::where('Status','!=', DELETED_FLG)->orderby('ModifiDate','desc')->get();
        
        return $data;
    }

    function getAllConnetBussinessesById($submenuid){       

        $data =  ConnectBusinesses::where('Status','!=', DELETED_FLG)
        ->where('SubMenuId', $submenuid)        
        ->get();
        
        return $data;
    }
    function getConnectBusinessesByUserId($id){
        $data =  ConnectBusinesses::where('Status','!=', DELETED_FLG)->where('UserId',$id)->orderBy('ModifiDate','desc')->get();
        return $data;
    }
}
