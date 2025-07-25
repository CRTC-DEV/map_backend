<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Map\GroupSearchMapItem;

/**
 * @OA\Tag(
 *     name="GroupSearchMapItem",
 *     description="API for GroupSearchMapItem"
 * )
 */

class GroupSearchMapItemAPI extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/groupsearchmapitem/{keysearch}",
     *     summary="Get GroupSearchMapItem resources",
     *     tags={"GroupSearchMapItem"},
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
    public function getGroupSearchMapItem($keysearch){        

        $obj_items = new GroupSearchMapItem();
        $items = $obj_items->getGroupSearchMapItemAPI($keysearch);
        
        return response()->json($items);
    }
    public function index()
    {
        // Logic for fetching all resources
    }

    /**
     * @OA\Post(
     *     path="/api/groupsearchmapitem",
     *     summary="Get GroupSearchMapItem resource",
     *     tags={"GroupSearchMapItem"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"keysearch"},     *             
     *             @OA\Property(property="keysearch", type="string", example=1),
     *             type="object"
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resource created"
     *     )
     * )
     */
    public function postGroupSearchMapItem(Request $request)
    {
       
        $keysearch = $request->input('keysearch');                       
        $obj_items = new GroupSearchMapItem();
        $items = $obj_items->getGroupSearchMapItemAPI($keysearch);
       
        return response()->json([
            'status' => 'success',
            'data' => $items,
            
        ]);
    }

    public function store(Request $request)
    {
        // Logic for storing a new resource
    }

}
