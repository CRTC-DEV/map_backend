<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Map\Event;

    /**
    * @OA\Tag(
    *     name="Event",
    *     description="API for Event"
    * )
    */

class EventAPI extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/event-all",
     *     summary="Get All Event resources",
     *     tags={"Event"},     * 
     *     
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */
    public function getEventAll() {
        // Logic for fetching all resources
        $obj = new Event;
        $items = $obj->getEventAllAPI();
        return response()->json($items);
       
    }
    
    /**
     * @OA\Get(
     *     path="/api/event&language={languageid}",
     *     summary="Get Event resources",
     *     tags={"Event"},
     * @OA\Parameter(
     *         name="languageid",
     *         in="path",
     *         required=true,
     *         description="Language Id",
     *         @OA\Schema(type="string")
     *     ),
     *     
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */
    public function getEvent($languegeid) {
        // Logic for fetching all resources
        $obj = new Event;
        $items = $obj->getEventByIdAPI($languegeid);
        return response()->json($items);
       
    }
    public function index()
    {
        // Logic for fetching all resources
    }

    /**
     * @OA\Post(
     *     path="/api/event",
     *     summary="Get Event resource",
     *     tags={"Event"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"languageid"},
     *             @OA\Property(property="languageid", type="string", example=1),     *            
     *             type="object"
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resource created"
     *     )
     * )
     */
    public function postEvent(Request $request){
        // Logic for storing a new resource
        $languegeid=$request->input('languageid');
        $obj = new Event;
        $items = $obj->getEventByIdAPI($languegeid);
        return response()->json($items);
    }

     /**
     * @OA\Put(
     *     path="/api/event",
     *     summary="Update Event resource",
     *     tags={"Event"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"eventid"},
     *             @OA\Property(property="eventid", type="string", example=1),     *            
     *             type="object"
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resource created"
     *     )
     * )
     */
    public function updateCounterEvent(Request $request){
        // Logic for storing a new resource
        $eventid=$request->input('eventid');
        $obj = new Event;
        $items = $obj->updateCounterEventAPI($eventid);
        return response()->json($items);
    }



    public function store(Request $request)
    {
        // Logic for storing a new resource
    }

}
