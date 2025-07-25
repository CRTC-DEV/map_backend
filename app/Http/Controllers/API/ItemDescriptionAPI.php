<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ItemDescription;

/**
 * @OA\Tag(
 *     name="ItemDescription",
 *     description="API for ItemDescription"
 * )
 */

class ItemDescriptionAPI extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/itemdescription/{id}",
     *     summary="Get ItemDescription resources",
     *     tags={"ItemDescription"},
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
    public function getItemDescription($id)
    {

        [$catid, $languageid, $floorid] = explode(",", $id);
        $obj_items = new ItemDescription();
        $items = $obj_items->getItemDescriptionAPI($catid, $languageid, $floorid);

        return response()->json($items);
    }
    public function index()
    {
        // Logic for fetching all resources
    }
    public function postItemDescription(Request $request)
    {
        // get data from body


        $catid = $request->input('catid');
        $languageid = $request->input('languageid');
        $floor = $request->input('floor');
        // get data from header
        $apiKey = $request->header('X-API-Key');

        // check api key
        // if (!$apiKey) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'API key is required'
        //     ], 401);
        // }

        $obj_items = new ItemDescription();
        $items = $obj_items->getItemDescriptionAPI($catid, $languageid,$floor);
        $t = $catid . '-' . $languageid.'-'.$floor;
        return response()->json([
            'status' => 'success',
            'data' => $items,
            'test' => $t
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/itemdescription",
     *     summary="Get ItemDescription resource",
     *     tags={"ItemDescription"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"floor","catid","languageid"},
     *             @OA\Property(property="floor", type="string", example=1),
     *             @OA\Property(property="catid", type="string", example=1),
     *             @OA\Property(property="languageid", type="string", example=1),
     *             type="object"
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resource created"
     *     )
     * )
     */

    public function store(Request $request)
    {
        // Logic for storing a new resource
    }

    
    public function update(Request $request, $id)
    {
        // Logic for updating a resource
    }

    
    public function destroy($id)
    {
        // Logic for deleting a resource
    }
}
