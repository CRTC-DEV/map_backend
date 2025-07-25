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
    

    /**
     * @OA\Get(
     *     path="/api/mapitem/{floor}",
     *     tags={"Map Items"},
     *     summary="Get map items by floor number",
     *     @OA\Parameter(
     *         name="floor",
     *         in="path",
     *         required=true,
     *         description="Floor number",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/MapItem")
     *             )
     *         )
     *     )
     * )
     */

    public function getMapItem($floor)
    {
        $obj_items = new MapItem();
        //$items = $obj_items->getItemDescriptionAPI($catId, $languageid,$floor);
        $items = $obj_items->getAllMapItemsAPI($floor);
        //dd($items);
        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/mapitem",
     *     tags={"Map Items"},
     *     summary="Get map items ",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"floor"},
     *             @OA\Property(property="floor", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/MapItem")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function postMapItem(Request $request)
    {
        // get data from body
        $floor = $request->input('floor');
        // get data from header
        $apiKey = $request->header('X-API-Key');
        // check api key
        // if (!$apiKey) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'API key is required'
        //     ], 401);
        $obj_items = new MapItem();
        //$items = $obj_items->getItemDescriptionAPI($catId, $languageid,$floor);
        $items = $obj_items->getAllMapItemsAPI($floor);
        //dd($items);
        return response()->json([
            'status' => 'success',
            'data' => $items
        ]);
    }
}
