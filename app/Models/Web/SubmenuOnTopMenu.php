<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class SubmenuOnTopmenu extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'SubmenuOnTopmenu';
    public $incrementing = false; // Không tự tăng
    protected $primaryKey = 'TopMenuId';

    // Add fields that can be mass-assigned
    protected $fillable = [ 'TopMenuId', 'SubMenuId', 'CreatedDate', 'ModifiDate','UserId','Status','OrderIndex']; // Example fields
    public $timestamps = false;

    public function topmenu()
    {
        return $this->belongsTo(TopMenu::class, 'TopMenuId', 'Id');
    }

    public function submenu()
    {
        return $this->belongsTo(SubMenu::class, 'SubMenuId', 'Id');
    }

    function getAllSubmenuOnTopmenu(){       

        $data =  SubmenuOnTopmenu::where('SubmenuOnTopmenu.Status', '!=', DELETED_FLG)
                ->with([
                    'topmenu.title.textcontent', // Load quan hệ `itemTitle` từ `signage`
                    'submenu.title.textcontent' // Load quan hệ `deviceTouch`
                ])->get();
        
        return $data;
    }

    function getSubmenuOnTopmenuById($TopMenuId,$SubMenuID){
        $return = SubmenuOnTopmenu::where('TopMenuId', $TopMenuId)
            ->where('SubMenuID',$SubMenuID)->first();
        return $return;
    }

    //Show for each Menu to AllSubmenu
    function getAllSubmenuOnTopmenuById($TopMenuId){
        $return = SubmenuOnTopmenu::where('TopMenuId', $TopMenuId)
        ->get();
        return $return;
    }

}
