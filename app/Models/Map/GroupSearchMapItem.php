<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class GroupSearchMapItem extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'GroupSearchMapItem';
    public $incrementing = false; // Không tự tăng
    protected $primaryKey = 'GroupSearchId';

    // Add fields that can be mass-assigned
    protected $fillable = [
        'MapItemId',
        'GroupSearchId',
        'Priority',
        'Status',
        'CreatedDate',
        'ModifiDate',
        'UserId',
        'IsShowBothLocation',
        'IsSearchAllFloor'
    ];
    public $timestamps = false;

    function getAllItems2()
    {

        //$item_title =  GroupSearch::where('Status', '!=', DELETED_FLG)->get();
        // $map_items =  ItemType::All();
        //return $item_title;
        return self::where('Status', '!=', DELETED_FLG)->get();
    }

    function getAllItems($search)
    {
        $return = GroupSearchMapItem::where('GroupSearchMapItem.Status', '!=', DELETED_FLG)
            ->join('GroupSearch', 'GroupSearch.Id', '=', 'GroupSearchMapItem.GroupSearchId')
            ->join('MapItem', 'MapItem.Id', '=', 'GroupSearchMapItem.MapItemId')
            ->select(
                'GroupSearchMapItem.*',
                'MapItem.KeySearch as MapItemKeySearch',
                'GroupSearch.Name as GroupSearchName',
                'GroupSearch.KeySearch as GroupSearchKeySearch'
            )
            ->orderBy('GroupSearch.Id', 'DESC');
        // ->get();
        //dd($return);  
        if (!empty($search)) {
            $return->where(function ($return) use ($search) {
                $return->where('GroupSearch.Name', 'like', '%' . $search . '%');
                // ->orWhere('GroupSearch.Name', 'like', '%' . $search . '%')
                // ->orWhere('GroupSearch.KeySearch', 'like', '%' . $search . '%');
            });
        }

        return $return->get();
    }

    public function getAllItemGroupSearchMapItem($search, $perPage)
    {
        // Build the base query
        $query = GroupSearchMapItem::where('GroupSearchMapItem.Status', '!=', DELETED_FLG)
            ->join('GroupSearch', 'GroupSearch.Id', '=', 'GroupSearchMapItem.GroupSearchId')
            ->join('MapItem', 'MapItem.Id', '=', 'GroupSearchMapItem.MapItemId')
            ->select(
                'GroupSearchMapItem.*',
                'MapItem.KeySearch as MapItemKeySearch',
                'MapItem.CadId as MapItemCadId',
                'GroupSearch.Name as GroupSearchName',
                'GroupSearch.KeySearch as GroupSearchKeySearch'
            )
            ->orderBy('GroupSearch.Id', 'DESC');

        // Apply search criteria if provided
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('MapItem.KeySearch', 'like', '%' . $search . '%')
                    ->orWhere('GroupSearch.Name', 'like', '%' . $search . '%')
                    ->orWhere('GroupSearch.KeySearch', 'like', '%' . $search . '%')
                    ->orWhere('GroupSearchMapItem.MapItemId', 'like', '%' . $search . '%')
                    ->orWhere('GroupSearchMapItem.GroupSearchId', 'like', '%' . $search . '%');
            });
        }

        // Paginate the query results
        // dd($query->paginate($perPage));
        return $query->paginate($perPage);
    }

    function insertItem($data)
    {
        //dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);

        $data['CreatedDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();
        // dd($data);
        return GroupSearchMapItem::insertGetId($data);
    }
    function updateItem($data, $GroupSearchId, $MapItemId)
    {
        // dd($data);
        $data['ModifiDate'] = \Carbon\Carbon::now()->setTimezone('GMT+7')->toDateTimeString();;
        return GroupSearchMapItem::
            where('GroupSearchId', $GroupSearchId)
            ->where('MapItemId', $MapItemId)
            ->update($data->toArray());
    }

    function deleteItem($MapItemId, $GroupSearchId)
    {
        return GroupSearchMapItem::where('MapItemId', $MapItemId)
            ->where('GroupSearchId', $GroupSearchId)
            ->delete();
    }



    function getItemById($GroupSearchId, $MapItemId)
    {
        $return = GroupSearchMapItem::where('GroupSearchId', $GroupSearchId)
            ->where('MapItemId', $MapItemId)
            ->where('GroupSearchMapItem.Status', '!=', DELETED_FLG)
            ->join('GroupSearch', 'GroupSearch.Id', '=', 'GroupSearchId')
            ->join('MapItem', 'MapItem.Id', '=', 'MapItemId')
            ->select(
                'GroupSearchMapItem.*' 
            )
            ->first();
        return $return;
    }
   
    //for API
    Function getGroupSearchMapItemOnDeviceTouchAPI($keysearch, $deviceSerial) {   
         
        $query = GroupSearchMapItem::where('GroupSearchMapItem.Status', '!=', DELETED_FLG)
            ->join('GroupSearch', 'GroupSearch.Id', '=', 'GroupSearchMapItem.GroupSearchId')
            ->join('MapItem', 'MapItem.Id', '=', 'GroupSearchMapItem.MapItemId')
            ->join('T2Location', 'T2Location.Id', '=', 'MapItem.T2LocationId')
            ->join('ItemTitle', 'ItemTitle.Id', '=', 'MapItem.TitleId')
            ->join('TextContent as TitleText', 'TitleText.Id', '=', 'ItemTitle.TextcontentId')
          //  ->join('DeviceTouchScreen', 'DeviceTouchScreen.AreaSide','=', 'MapItem.AreaSide')
            ->select('GroupSearchMapItem.*',       
                'MapItem.KeySearch as MapItemKeySearch','MapItem.Longitudes','MapItem.Latitudes',
                'MapItem.CadId','MapItem.TitleId', 
                'TitleText.OriginalText as TitleText',
                'ItemTitle.Id as ItemTitleId',
                'GroupSearch.Name as GroupSearchName',                
                'GroupSearch.KeySearch as GroupSearchKeySearch',
                'T2Location.Floor','T2Location.Name as LocationName',
                 'MapItem.AreaSide');
              // 'MapItem.AreaSide', 'DeviceTouchScreen.AreaSide as AreaSideofDevices');
                
                //dd($keysearch);

                 $queryDevice = DeviceTouchScreen::where('DeviceCode', $deviceSerial)->first(); 
                 $IsSideOfDevice = $queryDevice->AreaSide;
                 $FloorIdOfDevice = $queryDevice->T2LocationId;

                 $queryT2Location = T2Location::where('Id', $FloorIdOfDevice)->first();
                 $FloorOfDevice = $queryT2Location->Floor;
                 dd($IsSideOfDevice);
                // dd($FloorOfDevice);
              
        // Kiểm tra khoảng trắng trong keysearch
        $keysearch = trim($keysearch);
       
       
        if (str_contains($keysearch, ' ')) {
           
            // Nếu có khoảng trắng, sử dụng toán tử =
            //$query->where('GroupSearch.KeySearch', '=', $keysearch);
            $query->where('GroupSearch.KeySearch', 'LIKE', '%' . $keysearch . '%');

        } else {
           
            // Nếu không có khoảng trắng, sử dụng toán tử LIKE
            $query->where('GroupSearch.KeySearch', 'LIKE', '%' . $keysearch . '%');
                
        }
            $query->where(function($query ) use ($IsSideOfDevice){
                $query->where('GroupSearchMapItem.IsShowBothLocation', '=', 0)
                    ->where ('MapItem.AreaSide', '=', $IsSideOfDevice)
                    ->orwhere(function($query) {
                        $query->where('GroupSearchMapItem.IsShowBothLocation', '=', 1);
                });
            }); 

            $query->where(function($query ) use ($FloorOfDevice){
                $query->where('GroupSearchMapItem.IsSearchAllFloor', '=', 0)
                    ->where ('T2Location.Floor', '=', $FloorOfDevice)
                    ->orwhere(function($query) {
                        $query->where('GroupSearchMapItem.IsSearchAllFloor', '=', 1);
                });
            }); 
        
        // Sắp xếp theo Priority tăng dần (giá trị nhỏ lên đầu)
        $query->orderBy('GroupSearchMapItem.Priority', 'asc')
              ->take(20);  // Giới hạn 10 kết quả
       
        return $query->get();
    }
    
    function getGroupSearchMapItemAPI($keysearch) {       
        $query = GroupSearchMapItem::where('GroupSearchMapItem.Status', '!=', DELETED_FLG)
            ->join('GroupSearch', 'GroupSearch.Id', '=', 'GroupSearchMapItem.GroupSearchId')
            ->join('MapItem', 'MapItem.Id', '=', 'GroupSearchMapItem.MapItemId')
            ->join('T2Location', 'T2Location.Id', '=', 'MapItem.T2LocationId')
            ->join('ItemTitle', 'ItemTitle.Id', '=', 'MapItem.TitleId')
            ->join('TextContent as TitleText', 'TitleText.Id', '=', 'ItemTitle.TextcontentId')
            ->select('GroupSearchMapItem.*',       
                'MapItem.KeySearch as MapItemKeySearch','MapItem.Longitudes','MapItem.Latitudes',
                'MapItem.CadId','MapItem.TitleId', 
                'TitleText.OriginalText as TitleText',
                'ItemTitle.Id as ItemTitleId',
                'GroupSearch.Name as GroupSearchName',                
                'GroupSearch.KeySearch as GroupSearchKeySearch',
                'T2Location.Floor','T2Location.Name as LocationName');

                //dd($keysearch);

        // Kiểm tra khoảng trắng trong keysearch
        if (str_contains($keysearch, ' ')) {
           
            // Nếu có khoảng trắng, sử dụng toán tử =
            $query->where('GroupSearch.KeySearch', '=', $keysearch);
        } else {
           
            // Nếu không có khoảng trắng, sử dụng toán tử LIKE
            $query->where('GroupSearch.KeySearch', 'LIKE', '%' . $keysearch . '%');
        }

        // Sắp xếp theo Priority tăng dần (giá trị nhỏ lên đầu)
        $query->orderBy('GroupSearchMapItem.Priority', 'asc')
              ->take(10);  // Giới hạn 10 kết quả

        return $query->get();
    }

    

    function getGroupSearchWithMapItem($id)
    {
        $result = GroupSearchMapItem::where('GroupSearchId', $id)->get();
        return $result;
    }
}
