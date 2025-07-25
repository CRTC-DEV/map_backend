<?php

use App\Http\Livewire\Map\API\ItemTitleAPI;
use App\Http\Livewire\Map\Dashboard;
use App\Http\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Livewire\Map\MapItem\MapItemLive;
use App\Http\Livewire\Map\MapItem\MapItemAddLive;
use App\Http\Livewire\Map\MapItem\MapItemDetailLive;

use App\Http\Livewire\Map\ItemTitle\ItemTitleLive;
use App\Http\Livewire\Map\ItemTitle\ItemTitleAddLive;
use App\Http\Livewire\Map\ItemTitle\ItemTitleDetailLive;

use App\Http\Livewire\Map\RouteMapItem\RouteMapItemListLive;
use App\Http\Livewire\Map\RouteMapItem\RouteMapItemAddLive;
use App\Http\Livewire\Map\RouteMapItem\RouteMapItemDetailLive;

use App\Http\Livewire\Map\RouteMapItemDetail\RouteMapItemDetailListLive;
use App\Http\Livewire\Map\RouteMapItemDetail\RouteMapItemDetailAddLive;
use App\Http\Livewire\Map\RouteMapItemDetail\RouteMapItemDetailDetailLive;

use App\Http\Livewire\Map\T2Location\T2LocationListLive;
use App\Http\Livewire\Map\T2Location\T2LocationAddLive;
use App\Http\Livewire\Map\T2Location\T2LocationDetailLive;

use App\Http\Livewire\Map\TextContent\TextContentListLive;
use App\Http\Livewire\Map\TextContent\TextContentAddLive;
use App\Http\Livewire\Map\TextContent\TextContentDetailLive;

use App\Http\Livewire\Map\Translations\TranslationsAddLive;
use App\Http\Livewire\Map\Translations\TranslationsDetailLive;
use App\Http\Livewire\Map\Translations\TranslationsListLive;

//ItemType
use App\Http\Livewire\Map\ItemType\ItemTypeLive;
use App\Http\Livewire\Map\ItemType\ItemTypeAddLive;
use App\Http\Livewire\Map\ItemType\ItemTypeDetailLive;

//ItemDescription
use App\Http\Livewire\Map\ItemDescription\ItemDescriptionLive;
use App\Http\Livewire\Map\ItemDescription\ItemDescriptionAddLive;
use App\Http\Livewire\Map\ItemDescription\ItemDescriptionDetailLive;

//GroupSearch
use App\Http\Livewire\Map\GroupSearch\GroupSearchLive;
use App\Http\Livewire\Map\GroupSearch\GroupSearchAddLive;
use App\Http\Livewire\Map\GroupSearch\GroupSearchDetailLive;

//GroupSearchMapItem
use App\Http\Livewire\Map\GroupSearchMapItem\GroupSearchMapItemLive;
use App\Http\Livewire\Map\GroupSearchMapItem\GroupSearchMapItemAdd;
use App\Http\Livewire\Map\GroupSearchMapItem\GroupSearchMapItemDetail;

//Language
use App\Http\Livewire\Map\Languages\LanguagesListLive;
use App\Http\Livewire\Map\Languages\LanguagesAddLive;
use App\Http\Livewire\Map\Languages\LanguagesDetailLive;

//DeviceTouchScreen
use App\Http\Livewire\Map\DeviceTouchScreen\DeviceTouchScreenLive;
use App\Http\Livewire\Map\DeviceTouchScreen\DeviceTouchScreenAddLive;
use App\Http\Livewire\Map\DeviceTouchScreen\DeviceTouchScreenDetailLive;

//BannerAdvDeviceTouch
use App\Http\Livewire\Map\BannerAdvDeviceTouch\BannerAdvDeviceTouchLive;
use App\Http\Livewire\Map\BannerAdvDeviceTouch\BannerAdvDeviceTouchAddLive;
use App\Http\Livewire\Map\BannerAdvDeviceTouch\BannerAdvDeviceTouchDetailLive;

//ItemDescriptionAPI
use App\Http\Controllers\API\ItemDescriptionAPI;

// Admin Management
use App\Http\Livewire\Map\AdminManagement\AdminManagement;
use App\Http\Livewire\Map\AdminManagement\AdminManagementAdd;
use App\Http\Livewire\Map\AdminManagement\AdminManagementDetail;

//Banner Adv
use App\Http\Livewire\Map\BannerAdv\BannerAdvLive;
use App\Http\Livewire\Map\BannerAdv\BannerAdvAddLive;
use App\Http\Livewire\Map\BannerAdv\BannerAdvDetailLive;

//SignageDeviceTouch
use App\Http\Livewire\Map\SignageDeviceTouch\SignageDeviceTouchAddLive;
use App\Http\Livewire\Map\SignageDeviceTouch\SignageDeviceTouchLive;
use App\Http\Livewire\Map\SignageDeviceTouch\SignageDeviceTouchDetailLive;

//Signage
use App\Http\Livewire\Map\Signage\SignageAddLive;
use App\Http\Livewire\Map\Signage\SignageLive;
use App\Http\Livewire\Map\Signage\SignageDetailLive;

//SignageMapItem
use App\Http\Livewire\Map\SignageMapItem\SignageMapItemAddLive;
use App\Http\Livewire\Map\SignageMapItem\SignageMapItemLive;
use App\Http\Livewire\Map\SignageMapItem\SignageMapItemDetailLive;

//Main Functions
use App\Http\Livewire\Map\MainFunction\MainFunctionAddLive;
use App\Http\Livewire\Map\MainFunction\MainFunctionLive;
use App\Http\Livewire\Map\MainFunction\MainFunctionDetailLive;

//GroupMainFunction
use App\Http\Livewire\Map\GroupMainFunction\GroupMainFunctionLive;
use App\Http\Livewire\Map\GroupMainFunction\GroupMainFunctionAddLive;
use App\Http\Livewire\Map\GroupMainFunction\GroupMainFunctionDetailLive;

//GroupFunction
use App\Http\Livewire\Map\GroupFunction\GroupFunctionAddLive;
use App\Http\Livewire\Map\GroupFunction\GroupFunctionLive;
use App\Http\Livewire\Map\GroupFunction\GroupFunctionDetailLive;

//group function device touch
use App\Http\Livewire\Map\GroupFunctionDeviceTouch\GroupFunctionDeviceTouchAddLive;
use App\Http\Livewire\Map\GroupFunctionDeviceTouch\GroupFunctionDeviceTouchLive;
use App\Http\Livewire\Map\GroupFunctionDeviceTouch\GroupFunctionDeviceTouchDetailLive;

//Event
use App\Http\Livewire\Map\Event\EventAddLive;
use App\Http\Livewire\Map\Event\EventLive;
use App\Http\Livewire\Map\Event\EventDetailLive;

//Faq
use App\Http\Livewire\Map\Faq\FaqAddLive;
use App\Http\Livewire\Map\Faq\FaqLive;
use App\Http\Livewire\Map\Faq\FaqDetailLive;

//FaqType
use App\Http\Livewire\Map\FaqType\FaqTypeAddLive;
use App\Http\Livewire\Map\FaqType\FaqTypeLive;
use App\Http\Livewire\Map\FaqType\FaqTypeDetailLive;

//Faq
use App\Http\Livewire\Map\ContactNumber\ContactNumberAddLive;
use App\Http\Livewire\Map\ContactNumber\ContactNumberLive;
use App\Http\Livewire\Map\ContactNumber\ContactNumberDetailLive;

//FaqType
use App\Http\Livewire\Map\ContactNumberType\ContactNumberTypeAddLive;
use App\Http\Livewire\Map\ContactNumberType\ContactNumberTypeLive;
use App\Http\Livewire\Map\ContactNumberType\ContactNumberTypeDetailLive;

//KeySearch
use App\Http\Livewire\Map\KeySearch\KeySearchLive;

//EtagApi
use App\Http\Livewire\API\EtagApi;

use App\Http\Livewire\Map\UserInformation;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('set_layout_user')->group(function () {
    Route::redirect('/', 'login');
    Route::redirect('/login', 'map-login');
    Route::redirect('/map', 'map-login');
    Route::get('/map-login', Login::class)->name('login');
});


Route::middleware(['check_user'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::middleware(['module_permission:route-map-item'])->group(function () {
        // Route Map Item
        Route::get('/route-map-item', RouteMapItemListLive::class)->name('route-map-item');
        Route::get('/route-map-item-add', RouteMapItemAddLive::class)->name('route-map-item-add');
        Route::get('/route-map-item-edit/{id}', RouteMapItemDetailLive::class)->name('route-map-item-edit');
    });

    Route::middleware(['module_permission:route-map-item-detail'])->group(function () {
        // Route Map Item Detail
        Route::get('/route-map-item-detail', RouteMapItemDetailListLive::class)->name('route-map-item-detail');
        Route::get('/route-map-item-detail-add', RouteMapItemDetailAddLive::class)->name('route-map-item-detail-add');
        Route::get('/route-map-item-detail-edit/{id}', RouteMapItemDetailDetailLive::class)->name('route-map-item-detail-edit');
    });

    Route::middleware(['module_permission:group-search'])->group(function () {
        // Group Search
        Route::get('/group-search', GroupSearchLive::class)->name('group-search');
        Route::get('/group-search-add', GroupSearchAddLive::class)->name('group-search-add');
        Route::get('/group-search-edit/{id}', GroupSearchDetailLive::class)->name('group-search-edit');
    });

    Route::middleware(['module_permission:group-search-map-item'])->group(function () {
        // Group Search Map Item
        Route::get('/group-search-map-item', GroupSearchMapItemLive::class)->name('group-search-map-item');
        Route::get('/group-search-map-item-add', GroupSearchMapItemAdd::class)->name('group-search-map-item-add');
        Route::get('/group-search-map-item-edit/{id}', GroupSearchMapItemDetail::class)->name('group-search-map-item-edit');
    });

    Route::middleware(['module_permission:banner-adv'])->group(function () {
        // Banner Adv
        Route::get('/banner-adv', BannerAdvLive::class)->name('banner-adv');
        Route::get('/banner-adv-add', BannerAdvAddLive::class)->name('banner-adv-add');
        Route::get('/banner-adv-edit/{id}', BannerAdvDetailLive::class)->name('banner-adv-edit');
    });

    Route::middleware(['module_permission:device-touch-screen'])->group(function () {
        //DeviceTouchScreen
        Route::get('/device-touch-screen', DeviceTouchScreenLive::class)->name('device-touch-screen');
        Route::get('/device-touch-screen-add', DeviceTouchScreenAddLive::class)->name('device-touch-screen-add');
        Route::get('/device-touch-screen-edit/{id}', DeviceTouchScreenDetailLive::class)->name('device-touch-screen-edit');
    });

    Route::middleware(['module_permission:signage-devicetouch'])->group(function () {
        // signage devicetouch
        Route::get('/signage-devicetouch', SignageDeviceTouchLive::class)->name('signage-devicetouch');
        Route::get('/signage-devicetouch-add', SignageDeviceTouchAddLive::class)->name('signage-devicetouch-add');
        Route::get('/signage-devicetouch-edit/{id}', SignageDeviceTouchDetailLive::class)->name('signage-devicetouch-edit');
    });

    Route::middleware(['module_permission:signage'])->group(function () {
        // signage
        Route::get('/signage', SignageLive::class)->name('signage');
        Route::get('/signage-add', SignageAddLive::class)->name('signage-add');
        Route::get('/signage-edit/{id}', SignageDetailLive::class)->name('signage-edit');
    });

    Route::middleware(['module_permission:signage-mapitem'])->group(function () {
        // signage mapitem
        Route::get('/signage-mapitem', SignageMapItemLive::class)->name('signage-mapitem');
        Route::get('/signage-mapitem-add', SignageMapItemAddLive::class)->name('signage-mapitem-add');
        Route::get('/signage-mapitem-edit/{id}', SignageMapItemDetailLive::class)->name('signage-mapitem-edit');
    });

    Route::middleware(['module_permission:banner-adv-device-touch'])->group(function () {
        //BannerAdvDeviceTouch
        Route::get('/banner-adv-device-touch', BannerAdvDeviceTouchLive::class)->name('banner-adv-device-touch');
        Route::get('/banner-adv-device-touch-add', BannerAdvDeviceTouchAddLive::class)->name('banner-adv-device-touch-add');
        Route::get('/banner-adv-device-touch-edit/{id}', BannerAdvDeviceTouchDetailLive::class)->name('banner-adv-device-touch-edit');
    });

    Route::middleware(['module_permission:admin-management'])->group(function () {
        // Admin Management
        Route::get('/admin-management', AdminManagement::class)->name('admin-management');
        Route::get('/admin-management-add', AdminManagementAdd::class)->name('admin-management-add');
        Route::get('/admin-management-edit/{id}', AdminManagementDetail::class)->name('admin-management-edit');
    });

    Route::middleware(['module_permission:main-function'])->group(function () {
        //mainfunction
        Route::get('/mainfunction', MainFunctionLive::class)->name('mainfunction');
        Route::get('/mainfunction-add', MainFunctionAddLive::class)->name('mainfunction-add');
        Route::get('/mainfunction-edit/{id}', MainFunctionDetailLive::class)->name('mainfunction-edit');
    });

    Route::middleware(['module_permission:group-mainfunction'])->group(function () {
        //group main function
        Route::get('/group-mainfunction', GroupMainFunctionLive::class)->name('group-mainfunction');
        Route::get('/group-mainfunction-add', GroupMainFunctionAddLive::class)->name('group-mainfunction-add');
        Route::get('/group-mainfunction-edit/{id}', GroupMainFunctionDetailLive::class)->name('group-mainfunction-edit');
    });

    Route::middleware(['module_permission:group-function'])->group(function () {
        // group function
        Route::get('/groupfunction', GroupFunctionLive::class)->name('groupfunction');
        Route::get('/groupfunction-add', GroupFunctionAddLive::class)->name('groupfunction-add');
        Route::get('/groupfunction-edit/{id}', GroupFunctionDetailLive::class)->name('groupfunction-edit');
    });

    Route::middleware(['module_permission:group-function-device-touch'])->group(function () {
        // group function device
        Route::get('/groupfunction-devicetouch', GroupFunctionDeviceTouchLive::class)->name('groupfunction-devicetouch');
        Route::get('/groupfunction-devicetouch-add', GroupFunctionDeviceTouchAddLive::class)->name('groupfunction-devicetouch-add');
        Route::get('/groupfunction-devicetouch-edit/{id}', GroupFunctionDeviceTouchDetailLive::class)->name('groupfunction-devicetouch-edit');
    });

    Route::middleware(['module_permission:event'])->group(function () {
        // Event
        Route::get('/event', EventLive::class)->name('event');
        Route::get('/event-add', EventAddLive::class)->name('event-add');
        Route::get('/event-edit/{id}', EventDetailLive::class)->name('event-edit');
    });

    Route::middleware(['module_permission:faq'])->group(function () {
        // Faq
        Route::get('/faq', FaqLive::class)->name('faq');
        Route::get('/faq-add', FaqAddLive::class)->name('faq-add');
        Route::get('/faq-edit/{id}', FaqDetailLive::class)->name('faq-edit');
    });

    Route::middleware(['module_permission:faq-type'])->group(function () {
        // Faq-type
        Route::get('/faq-type', FaqTypeLive::class)->name('faq-type');
        Route::get('/faq-type-add', FaqTypeAddLive::class)->name('faq-type-add');
        Route::get('/faq-type-edit/{id}', FaqTypeDetailLive::class)->name('faq-type-edit');
    });

    Route::middleware(['module_permission:contact-number'])->group(function () {
        // Faq
        Route::get('/contact-number', ContactNumberLive::class)->name('contact-number');
        Route::get('/contact-number-add', ContactNumberAddLive::class)->name('contact-number-add');
        Route::get('/contact-number-edit/{id}', ContactNumberDetailLive::class)->name('contact-number-edit');
    });

    Route::middleware(['module_permission:contact-number-type'])->group(function () {
        // Faq-type
        Route::get('/contact-number-type', ContactNumberTypeLive::class)->name('contact-number-type');
        Route::get('/contact-number-type-add', ContactNumberTypeAddLive::class)->name('contact-number-type-add');
        Route::get('/contact-number-type-edit/{id}', ContactNumberTypeDetailLive::class)->name('contact-number-type-edit');
    });

    Route::middleware(['module_permission:map-item'])->group(function () {
        // Map Items
        Route::get('/map-item', MapItemLive::class)->name('map-item');
        Route::get('/map-item-add', MapItemAddLive::class)->name('map-item-add');
        Route::get('/map-item-edit/{id}', MapItemDetailLive::class)->name('map-item-edit');
    });

    Route::middleware(['module_permission:item-title'])->group(function () {
        // Item Title
        Route::get('/item-title', ItemTitleLive::class)->name('item-title');
        Route::get('/item-title-add', ItemTitleAddLive::class)->name('item-title-add');
        Route::get('/item-title-edit/{id}', ItemTitleDetailLive::class)->name('item-title-edit');
    });

    Route::middleware(['module_permission:t2-location'])->group(function () {
        // T2 Location
        Route::get('/t2-location', T2LocationListLive::class)->name('t2-location');
        Route::get('/t2-location-add', T2LocationAddLive::class)->name('t2-location-add');
        Route::get('/t2-location-edit/{id}', T2LocationDetailLive::class)->name('t2-location-edit');
    });

    Route::middleware(['module_permission:text-content'])->group(function () {
        // Text Content
        Route::get('/text-content', TextContentListLive::class)->name('text-content');
        Route::get('/text-content-add', TextContentAddLive::class)->name('text-content-add');
        Route::get('/text-content-edit/{id}', TextContentDetailLive::class)->name('text-content-edit');
    });

    Route::middleware(['module_permission:translation'])->group(function () {
        // Translation
        Route::get('/translations', TranslationsListLive::class)->name('translations');
        Route::get('/translations-add', TranslationsAddLive::class)->name('translations-add');
        Route::get('/translations-edit/{id}', TranslationsDetailLive::class)->name('translations-edit');
    });

    Route::middleware(['module_permission:item-type'])->group(function () {
        // Item Type
        Route::get('/item-type', ItemTypeLive::class)->name('item-type');
        Route::get('/item-type-add', ItemTypeAddLive::class)->name('item-type-add');
        Route::get('/item-type-edit/{id}', ItemTypeDetailLive::class)->name('item-type-edit');
    });

    Route::middleware(['module_permission:item-description'])->group(function () {
        // Item Description
        Route::get('/item-description', ItemDescriptionLive::class)->name('item-description');
        Route::get('/item-description-add', ItemDescriptionAddLive::class)->name('item-description-add');
        Route::get('/item-description-edit/{id}', ItemDescriptionDetailLive::class)->name('item-description-edit');
    });

    Route::middleware(['module_permission:language'])->group(function () {
        // Language
        Route::get('/languages', LanguagesListLive::class)->name('languages');
        Route::get('/languages-add', LanguagesAddLive::class)->name('languages-add');
        Route::get('/languages-edit/{id}', LanguagesDetailLive::class)->name('languages-edit');
    });


    // Route chỉ dành cho admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin-management', AdminManagement::class)->name('admin-management');
        Route::get('/admin-management-add', AdminManagementAdd::class)->name('admin-management-add');
        Route::get('/admin-management-edit/{id}', AdminManagementDetail::class)->name('admin-management-edit');
    });

    // Route key search
    Route::get('/key-search', KeySearchLive::class)->name('key-search');
    
    // Route dành cho user profile và đổi mật khẩu
    Route::get('/user-profile', UserInformation::class)->name('user.profile');
});
