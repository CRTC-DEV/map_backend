<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Map\RouteMapItemDetail;

/**
 * @OA\Tag(
 *     name="RouteMapItemDetail",
 *     description="API for RouteMapItemDetail"
 * )
 */

class RouteMapItemDetailAPI extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/routemapitemdetail/{id}",
     *     summary="Get RouteMapItemDetail resources",
     *     tags={"RouteMapItemDetail"},
     *     @OA\Parameter(
     *         name="id",
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

    public function getRouteMapItemDetail($id){       
        $obj_items = new RouteMapItemDetail();
        $items = $obj_items->getRouteMapItemDetailAPI($id);        
        return response()->json($items);
    }
    public function index()
    {
        // Logic for fetching all resources
    }

    /**
     * @OA\Post(
     *     path="/api/routemapitemdetail",
     *     summary="Get RouteMapItemDetail resource",
     *     tags={"RouteMapItemDetail"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="string", example=1),     *             
     *             type="object"
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resource created"
     *     )
     * )
     */

    public function postRouteMapItemDetail(Request $request){  
        $id = $request->input('id');    
        $obj_items = new RouteMapItemDetail();
        $items = $obj_items->getRouteMapItemDetailAPI($id);        
        return response()->json($items);
    }
    public function store(Request $request)
    {
        // Logic for storing a new resource
    }

    
}
