<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemTitle;


class TopMenu extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'TopMenu';
    public $primaryKey = 'Id';
    // Add fields that can be mass-assigned
    protected $fillable = [ 'CreatedDate', 'ModifiDate','UserId','Status','TitleId','Rank','OrderIndex'];
    public $timestamps = false;

    public function title()
    {
        return $this->belongsTo(ItemTitle::class, 'TitleId', 'Id');
    }

    function getAllTopMenu(){
        // $Language =  TopMenuTopMenuMapItem::All();
        $data =  TopMenu::where('TopMenu.Status', '!=', DELETED_FLG)
                    ->with('title.textcontent')
                    ->get();
        //dd($data);
        return $data;
    }

    function insertTopMenu($data){

        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        return TopMenu::insertGetId($data);
    }
    function updateTopMenu($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return TopMenu::where('Id', $id)->update($data->toArray());
    }

    function deletdTopMenu($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return TopMenu::where('Id', $id)->update($data->toArray());
    }

    function getTopMenuById($id){
        $return = TopMenu::where('Id', $id)->first();
        return $return;
    }
}
