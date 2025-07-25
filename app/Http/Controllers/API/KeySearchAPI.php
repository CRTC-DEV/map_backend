<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Map\KeySearch;

/**
 * @OA\Tag(
 *     name="KeySearch",
 *     description="API for KeySearch"
 * )
 */

class KeySearchAPI extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/keysearch",
     *     summary="Create KeySearch resource",
     *     tags={"KeySearch"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"InputSearch","DirectLink","DeviceId"},
     *             @OA\Property(property="InputSearch", type="string", example="search term"),
     *             @OA\Property(property="DirectLink", type="string", example="http://example.com"),
     *             @OA\Property(property="DeviceId", type="integer", example=1),
     *             type="object"
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="KeySearch created successfully"
     *     )
     * )
     */
    
    public function postKeySearch(Request $request)
    {
        // dd($request); // Debugging line to inspect the request data
        // Logic for posting a new KeySearch
        $keySearch = new KeySearch();
        $keySearch->InputSearch = $request->input('InputSearch');
        $keySearch->DirectLink = $request->input('DirectLink');
        $keySearch->DeviceCode = $request->input('DeviceCode');
        $keySearch->CreatedDate = now();
        $keySearch->ModifiDate = now();
        $keySearch->save();

        return response()->json(['message' => 'KeySearch created successfully'], 201);
    }
}
