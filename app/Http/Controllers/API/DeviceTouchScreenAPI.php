<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Map\DeviceTouchScreen;

/**
 * @OA\Tag(
 *     name="device-touch-screen",
 *     description="API for DeviceTouchScreen"
 * )
 */

class DeviceTouchScreenAPI extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/devicetouchscreen/{keysearch}",
     *     summary="Get DeviceTouchScreen resources",
     *     tags={"DeviceTouchScreen"},
     *     @OA\Parameter(
     *         name="keysearch",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */
    public function getDeviceTouchScreenbyCode($deviceCode){        

        $obj_items = new DeviceTouchScreen();
        
        $items = $obj_items->getDeviceTouchScreenByDeviceCode($deviceCode);
        //dd(json_encode($items));
        return response()->json($items);
    }

     public function getDeviceTouchScreenbySerial($deviceSerial){        

        $obj_items = new DeviceTouchScreen();
        
        $items = $obj_items->getDeviceTouchScreenByDeviceSerial($deviceSerial);
        //dd(json_encode($items));
        return response()->json($items);
    }

    public function index()
    {
        // Logic for fetching all resources
    }

    
    // public function postGroupSearchMapItem(Request $request)
    // {
       
       
    // }

    public function store(Request $request)
    {
        // Logic for storing a new resource
    }

}
