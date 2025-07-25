<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Map\GroupMainFunction;

/**
 * @OA\Tag(
 *     name="GroupMainFunctionSignage",
 *     description="API for GroupMainFunctionSignage"
 * )
 */

class GroupMainFunctionAPI extends Controller
{


    /**
     * @OA\Get(
     *     path="/api/groupmainfunctionsignage&language={languageid}&floor={floor}",
     *     summary="Get GroupMainFunction resources",
     *     tags={"GroupMainFunction"},
     * @OA\Parameter(
     *         name="languageid",
     *         in="path",
     *         required=true,
     *         description="Language Id",
     *         @OA\Schema(type="string")
     *     ),
     * @OA\Parameter(
     *         name="floor",
     *         in="path",
     *         required=true,
     *         description="Floor",
     *         @OA\Schema(type="string")
     *     ),
     *    
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */

    public function getGroupMainFunctionBySinage($languageid, $floor)
    {
        // Logic for fetching a single resource
        $obj = new GroupMainFunction();
        $items = $obj->getGroupMainFunctionBySinage($languageid, $floor);
        //$arr    = json($items);          
        return response()->json($items); //As data array
    }

    public function test(){
        dd(1);
    }

    public function getGroupMainFunctionByDevice($languageid, $floor, $deviceid)
    {
       
        // Logic for fetching a single resource
        $obj = new GroupMainFunction();
       
        $items = $obj->getGroupMainFunctionByDevice($languageid, $floor, $deviceid);
        //$arr    = json($items);         
        return response()->json($items); //As data array
    }

    public function getGroupMainFunctionBySinage_old($id)
    {
        // Logic for fetching a single resource
        $obj = new GroupMainFunction();
        $items = $obj->getGroupMainFunctionBySinageAPI($id);
        //$arr    = json($items);            
        return response()->json($items); //As data array
    }


    public function getGroupMainFunctionBySinage_new($id)
    {
        // Logic for fetching a single resource
        $obj = new GroupMainFunction();
        $items = $obj->getGroupMainFunctionBySinageAPI($id);

        // Extract Sub-SignagesId into an array
        $subSignagesIds = [];
        foreach ($items as $item) {
            if (isset($item['Sub-SignagesId'])) {
                $subSignagesIds = array_merge($subSignagesIds, json_decode($item['Sub-SignagesId'], true));
            }
        }

        // Remove duplicates and reindex the array
        $subSignagesIds = array_values(array_unique($subSignagesIds));
        //var_dump($subSignagesIds);

        return response()->json($subSignagesIds);
    }

    public function index()
    {
        // Logic for fetching all resources
    }

    /**
     * @OA\Post(
     *     path="/api/groupmainfunctionsignage",
     *     summary="Post groupmainfunctionsignage resource",
     *     tags={"GroupMainFunction"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"G-Id","LanguageId"},
     *             @OA\Property(property="G-Id", type="string", example=1),
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

    public function postGroupMainFunctionBySinage(Request $request)
    {
        // Logic for fetching a single resource
        $g_id = $request->input('G-Id'); 
        $languageid = $request->input('LanguageId'); 
        $obj = new GroupMainFunction();
        $items = $obj->postGroupMainFunctionBySinage($g_id);
        //$arr    = json($items);            
        return response()->json($items); //As data array
    }
    public function store(Request $request)
    {
        // Logic for storing a new resource
    }
}
