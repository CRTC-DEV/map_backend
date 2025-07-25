<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemTitle;
use App\Models\ItemDescription;

class Faq extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'Faq';
    public $primaryKey = 'Id';
    // Add fields that can be mass-assigned
    protected $fillable = ['TitleId', 'DescriptionId', 'CreatedDate', 'ModifiDate','UserId','Status','FAQTypeId','Rank']; // Example fields
    public $timestamps = false;

    public function title()
    {
        return $this->belongsTo(ItemTitle::class, 'TitleId', 'Id');
    }
    public function description()
    {
        return $this->belongsTo(ItemDescription::class, 'DescriptionId', 'Id');
    }
    public function faqtype()
    {
        return $this->belongsTo(FaqType::class, 'FAQTypeId', 'Id');
    }
    function getAllFaq(){
        // $Language =  FaqFaqMapItem::All();
        $data =  Faq::where('Faq.Status', '!=', DELETED_FLG)
                    ->with('title.textcontent','description.textcontent','faqtype.title.textcontent')
                    ->get();
        //dd($data);
        return $data;
    }

    function insertFaq($data){
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return Faq::insertGetId($data);
    }
    function updateFaq($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return Faq::where('Id', $id)->update($data->toArray());
    }

    function deletdFaq($data, $id){

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['Status'] = DELETED_FLG;
        // dd($data);
        return Faq::where('Id', $id)->update($data->toArray());
    }

    function getFaqById($id){
        $return = Faq::where('Id', $id)->first();
        return $return;
    }
}
