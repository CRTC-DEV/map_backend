<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Map\SignageMapItem;

    /**
    * @OA\Tag(
    *     name="SignageMapItem",
    *     description="API for SignageMapItem"
    * )
    */

class SignageMapItemAPI extends Controller
{
    
    
    /**
     * @OA\Get(
     *     path="/api/signagemapitem/{id}",
     *     summary="Get SignageMapItem resources",
     *     tags={"SignageMapItem"},
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
    public function getSignageMapItem(){        
        //$obj = new SignageMapItem();
        $floor="2";
        $signagetitle="Toilet";
        $languageid="5"; // English
        $return =  SignageMapItem::where('SignageMapItem.Status', '!=', DELETED_FLG)
                    ->join('Signages','Signages.Id','=','SignageId')
                    ->join('MapItem', 'MapItem.Id', '=','MapItemId')
                    ->join('T2Location', 'MapItem.T2LocationId', '=','T2Location.Id')
                    ->join('ItemTitle', 'ItemTitle.Id','=','Signages.TitleId')
                    ->join('ItemType', 'ItemType.Id','=','Signages.TitleId')
                    ->join('TextContent', 'TextContent.Id', '=','ItemTitle.TextContentId')
                    ->join('Translations', 'Translations.TextContentId', '=','TextContent.Id')
                    ->join('Languages', 'Languages.Id','=','Translations.LanguageId')
                    ->select('T2Location.Floor','ItemType.Name as SignageTitle'
                    ,'MapItem.CadId as MapItem','MapItem.Longitudes','MapItem.Latitudes','Languages.Id  as Languages.Id'  ,'Languages.Name as LanguageName')
                    ->where('T2Location.Floor', '=', $floor)
                    ->where('ItemType.Name', '=', $signagetitle)
                    ->where('Languages.Id', '=', $languageid)
                    
                    ->get();   

        return response()->json($return);
        
    }
    


    public function index()
    {
        // Logic for fetching all resources
    }

    /**
     * @OA\Post(
     *     path="/api/signagemapitem",
     *     summary="Get SignageMapItem resource",
     *     tags={"SignageMapItem"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"floor","signagetitle","languageid"},
     *             @OA\Property(property="floor", type="string", example=1),
     *             @OA\Property(property="signagetitle", type="string", example=1),
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
    public function postSignageMapItem(Request $request){
        $floor = $request->input('floor');
        $signagetitle = $request->input('signagetitle');
        $languageid = $request->input('languageid');
        $obj = new SignageMapItem();
        $item = $obj->getSignageMapItem($floor, $signagetitle ,$languageid); 
        $item['floor'] = $floor;
        $item['signagetitle'] = $signagetitle;
        $item['languageid'] = $languageid;       
        return response()->json($item);
        
    }
    public function store(Request $request)
    {
        // Logic for storing a new resource
    }

    
}
