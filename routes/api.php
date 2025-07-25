<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//For Swagger API
use App\Http\Controllers\API\MapItemAPI;
use App\Http\Controllers\API\ItemDescriptionAPI;
use App\Http\Controllers\API\GroupSearchMapItemAPI;
use App\Http\Controllers\API\RouteMapItemDetailAPI;
use App\Http\Controllers\API\SignageAPI;
use App\Http\Controllers\API\SignageMapItemAPI;
use App\Http\Controllers\API\SignageDeviceTouchAPI;
use App\Http\Controllers\API\GroupFunctionDeviceAPI;
use App\Http\Controllers\API\GroupMainFunctionAPI;

use App\Http\Controllers\API\EventAPI;
use App\Http\Controllers\API\DeviceTouchScreenAPI;
use App\Http\Controllers\API\KeySearchAPI;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//for API Swagger
Route::prefix('v1')->group(function () {
    Route::get('map-items/{floor}', [MapItemAPI::class, 'getMapItem']);  
   
});

//Map Item SW
Route::get('/mapitem/{floor}', [MapItemAPI::class, 'getMapItem'])->name('api.map-item.get');
Route::post('/mapitem', [MapItemAPI::class, 'postMapItem'])->name('api.map-item.post');

//Item Description SW
Route::get('/itemdescription/{Id}', [ItemDescriptionAPI::class, 'getItemDescription'])->name('api.item-description.get');
Route::post('/itemdescription', [ItemDescriptionAPI::class, 'postItemDescription'])->name('api.item-description.post');

//Route Map Item Details SW
Route::get('/routemapitemdetail/{id}', [RouteMapItemDetailAPI::class, 'getRouteMapItemDetail'])->name('api.route-map-item-detail.get');
Route::post('/routemapitemdetail', [RouteMapItemDetailAPI::class, 'postRouteMapItemDetail'])->name('api.route-map-item-detail.post');

//Group Search Map Item SW
Route::get('/groupsearchmapitem/{keysearch}', [GroupSearchMapItemAPI::class, 'getGroupSearchMapItem'])->name('api.group-search-map-item.get');
Route::get('/groupsearchmapitemondevice/{keysearch}/{deviceserial}', [GroupSearchMapItemAPI::class, 'getGroupSearchMapItemOnDevice'])->name('api.group-search-map-item.get');
Route::post('/groupsearchmapitem', [GroupSearchMapItemAPI::class, 'postGroupSearchMapItem'])->name('api.group-search-map-item.post');

//Signage SW
Route::get('/signage/all', [SignageAPI::class, 'getSignageAll'])->name('api.signage.get');
Route::get('/signage&language={languageid}', [SignageAPI::class, 'getSignage'])->name('api.signage.get');
Route::post('/signage', [SignageAPI::class, 'postSignage'])->name('api.signage.post');

//Signage Map Item SW
Route::get('/signagemapitem/{id}', [SignageMapItemAPI::class, 'getSignageMapItem'])->name('api.signage-map-item.get');
Route::post('/signagemapitem', [SignageMapItemAPI::class, 'postSignageMapItem'])->name('api.signage-map-item.post');

//Signage Device Touch
Route::get('/signagedevicetouch', [SignageDeviceTouchAPI::class, 'getSignageDeviceTouch'])->name('api.signage-device-touch.get');
Route::post('/signagedevicetouch', [SignageDeviceTouchAPI::class, 'postSignageDeviceTouch'])->name('api.signage-device-touch.post');

//Group MainFunction - Device Touch
//Route::get('/groupmainfunction/{id}', [GroupMainFunctionAPI::class, 'getGroupMainFunction'])->name('api.group-mainfunction.get');
Route::get('/groupfunctiondevice', [GroupFunctionDeviceAPI::class, 'getGroupMainFunctionDevice'])->name('api.group-function-device.get');
Route::post('/groupfunctiondevice', [GroupFunctionDeviceAPI::class, 'postGroupMainFunctionDevice'])->name('api.group-function-device.post');

//Group main funciton signages
Route::get('/groupmainfunctionsignage&language={languageid}&floor={floor}', [GroupMainFunctionAPI::class, 'getGroupMainFunctionBySinage'])->name('api.group-mainfunction-signage.get');
Route::get('/groupmainfunctiondevice&language={languageid}&floor={floor}&device={deviceid}', [GroupMainFunctionAPI::class, 'getGroupMainFunctionByDevice'])->name('api.group-mainfunction-device.get');
// Route::get('/test', [GroupMainFunctionAPI::class, 'test'])->name('api.test.get');
Route::post('/groupmainfunctionsignage', [GroupMainFunctionAPI::class, 'postGroupMainFunctionBySinage'])->name('api.group-mainfunction-signage.post');


//Event SW
Route::get('/event-all', [EventAPI::class, 'getEventAll'])->name('api.eventall.get');
Route::get('/event&language={languageid}', [EventAPI::class, 'getEvent'])->name('api.event.get');
Route::post('/event', [EventAPI::class, 'postEvent'])->name('api.event.post');
Route::put('/event', [EventAPI::class, 'updateCounterEvent'])->name('api.event.put');

//DeviceTouchScreen
Route::get('/getdevicetouchbycode/{devicecode}',[DeviceTouchScreenAPI::class, 'getDeviceTouchScreenbyCode'])->name('api.devicetouch.get') ;
Route::get('/getdevicetouchbyserial/{deviceserial}',[DeviceTouchScreenAPI::class, 'getDeviceTouchScreenbySerial'])->name('api.devicetouch.get') ;

//key search
Route::post('/keysearch', [KeySearchAPI::class, 'postKeySearch'])->name('api.keysearch.post');
