<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Map\Signages;

/**
 * @OA\Tag(
 *     name="Signage",
 *     description="API for Signage"
 * )
 */

class SignageAPI extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/signage&language={languageid}",
     *     summary="Get Signage resources",
     *     tags={"Signage"},
     *      @OA\Parameter(
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
    public function getSignageAll(){

        $obj_signages = new Signages();
        $signages = $obj_signages->getSignageAllAPI();        
        return response()->json($signages);//As data array
        
    }
    public function getSignage($languageid){

        $obj_signages = new Signages();
        $signages = $obj_signages->getSignageAPI($languageid);        
        return response()->json($signages);//As data array
        
    }

    public function index()
    {
        // Logic for fetching all resources
    }

    /**
     * @OA\Post(
     *     path="/api/signage",
     *     summary="Get Signage resource",
     *     tags={"Signage"},
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
    public function postSignage(Request $request){
        $id = $request->input('id'); 
        $languageid = $request->input('languageid'); 

        $obj_signages = new Signages();
        $signages = $obj_signages->getSignageAPI($id,$languageid);
        
        return response()->json($signages);
        
    }
    public function store(Request $request)
    {
        // Logic for storing a new resource
    }

    
}
