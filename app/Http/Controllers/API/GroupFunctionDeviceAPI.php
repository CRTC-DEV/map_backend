<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Models\Map\GroupFunction;
use App\Models\Map\MainFunction;
//use App\Models\Map\GroupMainFunction;
use App\Models\Map\GroupFunctionDeviceTouch;

    /**
    * @OA\Tag(
    *     name="GroupFunctionDevice",
    *     description="API for GroupFunctionDevice"
    * )
    */

class GroupFunctionDeviceAPI extends Controller
{
    
    
    /**
     * @OA\Get(
     *     path="/api/groupfunctiondevice",
     *     summary="Get GroupFunctionDevice resources",
     *     tags={"GroupFunctionDevice"},
     *     
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */

    public function getGroupMainFunctionDevice(){

        $obj1 = new GroupFunctionDeviceTouch();
        $items1 = $obj1->getGroupMainFunctionDevice();        
        return response()->json($items1);//As data array

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
     *     path="/api/groupfunctiondevice",
     *     summary="Get GroupFunctionDevice resource",
     *     tags={"GroupFunctionDevice"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"DeviceId","LanguageId"},
     *             @OA\Property(property="DeviceId", type="string", example=1),
     *             @OA\Property(property="LanguageId", type="string", example=1),
     *                      
     *             type="object"
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resource created"
     *     )
     * )
     */
    public function postGroupMainFunctionDevice(Request $request){
        // Logic for storing a new resource
        $deviceid = $request->input('DeviceId'); 
        $languageid = $request->input('LanguageId'); 
        //$languageid = 1;

        $obj = new GroupFunctionDeviceTouch();
        $items = $obj->getGroupMainFunctionDeviceAPI($deviceid,$languageid);
        
        return response()->json($items);
    }
    public function store(Request $request)
    {
        // Logic for storing a new resource
    }

    
}
