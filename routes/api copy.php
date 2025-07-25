<?php

use App\Http\Livewire\API\EtagApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\API\ItemTitleAPI;
use App\Http\Livewire\API\MapItemAPI;

use App\Http\Livewire\API\ItemDescriptionAPI;
use App\Http\Livewire\API\GroupSearchMapItemAPI;
use App\Http\Livewire\API\RouteMapItemDetailAPI;

//for Swagger API
use App\Http\Controllers\API\MapItemAPI_SW;
// use App\Http\Controllers\API\MapItemController;
// use App\Http\Livewire\GroupSearch\GroupSearchLive;

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

// Route::get('/item-title', function () {
//     $item = ItemTitle::all();
//     return response()->json($item); // Fetch all records from the `locations` table
// });

// Route::get('/item-title', [ItemTitleController::class, 'getAllItemTitle'])->name('api.item-title');
//FOR GET API
//MapItem
Route::get('/map-item', [MapItemAPI::class, 'getAllItemTitle'])->name('api.map-item');
Route::get('/map-item/{floor}', [MapItemAPI::class, 'getMapItem'])->name('api.map-item');

//ItemDescription
Route::get('/item-description/{catid}/{languageid}', [ItemDescriptionAPI::class, 'getItemDescriptionAPI'])->name('api.item-description');
Route::get('/item-description/{id}', [ItemDescriptionAPI::class, 'getItemDescriptionAPI'])->name('api.item-description');
Route::get('/item-description-all', [ItemDescriptionAPI::class, 'getItemDescription_All'])->name('api.item-description');

//GroupSearchMapItem
Route::get('/group-search-map-item', [GroupSearchMapItemAPI::class, 'getGroupSearchMapItemAPI'])->name('api.group-search-map-item');
Route::get('/group-search-map-item/{keysearch}', [GroupSearchMapItemAPI::class, 'getGroupSearchMapItemAPI'])->name('api.group-search-map-item');
Route::get('/group-search-map-item-all', [GroupSearchMapItemAPI::class, 'getGroupSearchMapItem_All'])->name('api.group-search-map-item-all');

//RouteMapItemDetail
Route::get('/route-map-item-detail/{route_map_item_id}', [RouteMapItemDetailAPI::class, 'getRouteMapItemDetailAPI'])->name('api.route-map-item-detail');    


// Post tmiddleware api
//Route::post('/item-description-post', [ItemDescriptionAPI::class, 'getItemDescriptionFromBody'])
    //->name('api.item-description.body');
//for POST API
Route::post('/item-description-post', [ItemDescriptionAPI::class, 'getItemDescriptionFromBody'])
    ->name('api.item-description.post');

Route::post('/map-item-post', [MapItemAPI::class, 'getMapItemFromBody'])
    ->name('api.map-item.post');


//for EtagApi
Route::middleware('etag')->group(function () {
    Route::post('/etag-map-item', [MapItemAPI::class, 'getMapItemFromBody'])->name('api.map-item.post');
    Route::post('/etag-signage', [EtagApi::class, 'getEtagSignage'])->name('api.etag-signage.post');
    //Route::get('/items', [ItemController::class, 'index'])->name('api.items.index');
    //Route::get('/items/{id}', [ItemController::class, 'show'])->name('api.items.show');
});

//for API Swagger
Route::prefix('v1')->group(function () {
    Route::get('map-items/{floor}', [MapItemAPI_SW::class, 'getMapItem']);
   
   
   
   
   
   
});