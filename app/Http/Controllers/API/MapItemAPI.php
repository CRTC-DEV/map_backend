<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Map\MapItem;

/**
 * @OA\Tag(
 *     name="Map Items",
 *     description="API for Map Item"
 * )
 */

class MapItemAPI extends Component
{
    
    public function getMapItem($floor)
    {
        $obj_items = new MapItem();
        $items = $obj_items->getAllMapItemsAPI($floor);
        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }
    public function postMapItem(Request $request)
    {
        $floor = $request->input('floor');
        $apiKey = $request->header('X-API-Key');
        $obj_items = new MapItem();
        $items = $obj_items->getAllMapItemsAPI($floor);
        //dd($items);
        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    // get full map item without floor
    public function getMapItemFull()
    {
        $obj_items = new MapItem();
        $items = $obj_items->getAllMapItemsFull();
        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }
}
