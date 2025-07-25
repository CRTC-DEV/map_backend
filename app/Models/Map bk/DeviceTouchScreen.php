<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use App\Models\Map\T2Location;

class DeviceTouchScreen extends Model
{
    protected $table = 'DeviceTouchScreen';
    
    // Disable automatic timestamps
    protected $primaryKey = 'Id';
    public $timestamps = false;

    // Dynamically set the fillable columns
    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Ensure $columns is always an array
        $columns = Schema::hasTable($this->getTable()) 
            ? Schema::getColumnListing($this->getTable()) 
            : [];

        // Populate the fillable property dynamically
        $this->fillable = array_diff($columns, ['Id']);
    }

    /**
     * Update an arrival movement record by MovementId
     *
     * @param array $data
     * @param int $movementId
     * @return int
     */

    
    function getAllDeviceTouchScreens(){

        $device_touch_screens = DeviceTouchScreen::where('Status', '!=', DELETED_FLG)
            ->orderBy('Id','DESC')->get();
        
        return $device_touch_screens;
    }

    public function t2location()
    {
        return $this->belongsTo(T2Location::class, 'T2LocationId', 'Id');
    }
    
    public function updateDeviceTouchScreen($data, $Id)
    {
        $data['CreatedDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        return self::where('Id', $Id)->update($data->toArray());
    }

    function insertDeviceTouchScreen($data){  
        $data['CreatedDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString(); 
        //dd($data);     
        return DeviceTouchScreen::insertGetId($data);
    }

    function getDeviceTouchScreenById($id){
        $return = DeviceTouchScreen::where('Id', $id)->first();
        return $return;
    }

    function deleteDeviceTouchScreenById($id){
        return DeviceTouchScreen::where('Id', $id)->update(['Status' => DELETED_FLG]);
    }
}
