<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Map\SignageDeviceTouch;

    /**
    * @OA\Tag(
    *     name="SignageDeviceTouch",
    *     description="API for SignageDeviceTouch"
    * )
    */

class SignageDeviceTouchAPI extends Controller
{
    
    
    /**
     * @OA\Get(
     *     path="/api/signagedevicetouch",
     *     summary="Get SignageDeviceTouch resources",
     *     tags={"SignageDeviceTouch"},
     *     
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */

    public function getSignageDeviceTouch(){

        $obj = new SignageDeviceTouch();
        $items = $obj->getAllSignageDeviceTouchAPI();
        return response()->json($items);//As data array

        // $obj2 = new MainFunction();
        // $items2=$obj2->getSubFunction();

        // return response()->json($items2);//As data array

    }
    public function index()
    {
        // Logic for fetching all resources
    }

    /**
     * @OA\Post(
     *     path="/api/signagedevicetouch",
     *     summary="Get SignageDeviceTouch resource",
     *     tags={"SignageDeviceTouch"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"DeviceTouchScreenId","LanguageId"},
     *             @OA\Property(property="DeviceTouchScreenId", type="string", example=1),
     *             @OA\Property(property="LanguageId", type="string", example=1),     *            
     *             type="object"
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resource created"
     *     )
     * )
     */
    public function postSignageDeviceTouch(Request $request){

       
        $deviceid = $request->input('DeviceTouchScreenId'); 
        $languageid = $request->input('LanguageId');       
        
        $obj = new SignageDeviceTouch();
        $items = $obj->getSignageDeviceTouchAPI($deviceid,$languageid);
        
        return response()->json($items);

    }
    public function store(Request $request)
    {
        // Logic for storing a new resource
    }

    
}
