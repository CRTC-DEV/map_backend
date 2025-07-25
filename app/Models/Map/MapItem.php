<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;

class MapItem extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'MapItem';

    // Add fields that can be mass-assigned
    protected $fillable = ['CadId', 'KeySearch', 'Status', 'CreateDate', 'ModifiDate', 'T2LocationId', 'TitleId', 'DescriptionId', 'ItemTypeId', 'UserId', 'Longitudes', 'Latitudes', 'Rank', 'AreaSide', 'ImgUrl']; // Example fields
    public $timestamps = false;
    function getAllMapItems()
    {
        $data = MapItem::where('MapItem.Status', '!=', DELETED_FLG)
            // Join với T2Location bằng T2LocationId
            ->join('T2Location', 'T2Location.Id', '=', 'MapItem.T2LocationId')
            // Join với ItemTitle bằng TitleId
            ->join('ItemTitle', 'ItemTitle.Id', '=', 'MapItem.TitleId')
            // Join với ItemDescription bằng DescriptionId
            ->join('ItemDescription', 'ItemDescription.Id', '=', 'MapItem.DescriptionId')
            // Join với TextContent cho ItemTitle
            ->join('TextContent as TitleText', 'TitleText.Id', '=', 'ItemTitle.TextcontentId')
            // Join với TextContent cho ItemDescription
            ->join('TextContent as DescriptionText', 'DescriptionText.Id', '=', 'ItemDescription.TextcontentId')
            // Chọn các cột cần thiết từ các bảng đã join
            ->select(
                'MapItem.*',
                'T2Location.Zone',
                'T2Location.Floor',
                'T2Location.Name as LocationName',
                'ItemTitle.Id as ItemTitleId',
                'TitleText.OriginalText as TitleText',
                'ItemDescription.Id as ItemDescriptionId',
                'DescriptionText.OriginalText as DescriptionText'
            )
            ->get();
            
        // Xử lý URL hình ảnh cho từng item
        foreach ($data as $item) {
            // Đảm bảo URL hình ảnh đầy đủ nếu tồn tại
            if ($item->ImgUrl && strpos($item->ImgUrl, 'http://') !== 0 && strpos($item->ImgUrl, 'https://') !== 0 && strpos($item->ImgUrl, '/') !== 0) {
                $item->ImgUrl = url('storage/' . $item->ImgUrl);
            }
        }
        
        return $data;
    }

    function insertMapItem($data)
    {
        // dd($data);
        $data['UserId'] = auth()->guard('admin')->check() ? ROLE_ADMIN_WEBSITE : (auth()->guard('user')->check() ? ROLE_ADMIN_MAP : null);
        $data['CreatedDate'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();
        // dd($data);
        return MapItem::insertGetId($data);
    }
    function updateMapItem($data, $id)
    {

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        return MapItem::where('Id', $id)->update($data->toArray());
    }

    function deleteMapItem($data, $id)
    {

        $data['ModifiDate'] = \Carbon\Carbon::now()->toDateTimeString();

        return MapItem::where('Id', $id)->update($data);
    }

    function getMapItemById($id)
    {
        $data = MapItem::where('MapItem.Status', '!=', DELETED_FLG)
            // Filter by MapItem.Id
            ->where('MapItem.Id', $id)
            // Join with T2Location by T2LocationId
            ->join('T2Location', 'T2Location.Id', '=', 'MapItem.T2LocationId')
            // Join with ItemTitle by TitleId
            ->join('ItemTitle', 'ItemTitle.Id', '=', 'MapItem.TitleId')
            // Join with ItemDescription by DescriptionId
            ->join('ItemDescription', 'ItemDescription.Id', '=', 'MapItem.DescriptionId')
            // Join with TextContent for ItemTitle
            ->join('TextContent as TitleText', 'TitleText.Id', '=', 'ItemTitle.TextcontentId')
            // Join with TextContent for ItemDescription
            ->join('TextContent as DescriptionText', 'DescriptionText.Id', '=', 'ItemDescription.TextcontentId')
            // Select necessary columns from the joined tables
            ->select(
                'MapItem.*',
                'T2Location.Zone',
                'T2Location.Floor',
                'T2Location.Name as LocationName',
                'T2Location.Id as LocationId',
                'ItemTitle.Id as ItemTitleId',
                'TitleText.OriginalText as TitleText',
                'ItemDescription.Id as ItemDescriptionId',
                'DescriptionText.OriginalText as DescriptionText'
            )
            ->first(); // Use first() instead of get() since you're expecting only one item based on Id
            
        // Xử lý URL hình ảnh cho item nếu tồn tại
        if ($data && $data->ImgUrl && strpos($data->ImgUrl, 'http://') !== 0 && strpos($data->ImgUrl, 'https://') !== 0 && strpos($data->ImgUrl, '/') !== 0) {
            $data->ImgUrl = url('storage/' . $data->ImgUrl);
        }
        
        return $data;
    }

    //for API
    function getAllMapItemsAPI($floor)
    {
        $data = MapItem::where('MapItem.Status', '!=', DELETED_FLG)
            // Filter by MapItem.Id
            ->where('T2Location.Floor', $floor)
            // Join with T2Location by T2LocationId
            ->join('T2Location', 'T2Location.Id', '=', 'MapItem.T2LocationId')
            // Join with ItemTitle by TitleId
            ->join('ItemTitle', 'ItemTitle.Id', '=', 'MapItem.TitleId')
            // Join with ItemDescription by DescriptionId
            ->join('ItemDescription', 'ItemDescription.Id', '=', 'MapItem.DescriptionId')
            // Join with TextContent for ItemTitle
            ->join('TextContent as TitleText', 'TitleText.Id', '=', 'ItemTitle.TextcontentId')
            // Join with TextContent for ItemDescription
            ->join('TextContent as DescriptionText', 'DescriptionText.Id', '=', 'ItemDescription.TextcontentId')
            //Join with ItemType
            ->join('ItemType', 'ItemType.Id', '=', 'MapItem.ItemTypeId')
            // Select necessary columns from the joined tables
            ->select(
                'MapItem.*',
                'T2Location.Zone',
                'T2Location.Floor',
                'T2Location.Name as LocationName',
                'T2Location.Id as LocationId',
                'ItemTitle.Id as ItemTitleId',
                'TitleText.OriginalText as TitleText',
                'ItemType.IsShow as ItemTypeIsShow',
                'ItemDescription.Id as ItemDescriptionId',
                'DescriptionText.OriginalText as DescriptionText'
            )
            ->get(); 

        // Xử lý URL hình ảnh cho từng item
        foreach ($data as $item) {
            // Đảm bảo URL hình ảnh đầy đủ nếu tồn tại
            if ($item->ImgUrl && strpos($item->ImgUrl, 'http://') !== 0 && strpos($item->ImgUrl, 'https://') !== 0 && strpos($item->ImgUrl, '/') !== 0) {
                $item->ImgUrl = url('storage/' . $item->ImgUrl);
            }
        }
            
        return $data;
    }
}
