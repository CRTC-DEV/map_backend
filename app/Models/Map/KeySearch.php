<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemTitle;
use App\Models\Map\ItemType;


class KeySearch extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'KeySearch';
    protected $primaryKey = 'Id'; // Đặt khóa chính là 'Id'
    protected $fillable = [
       
        'InputSearch',
        'DirectLink',
        'DeviceCode',
        'CreatedDate',
        'ModifiDate',
    ];
    public $timestamps = false;

    public function getAllItems()
    {
        return $this->all();
    }
}
