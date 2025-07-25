<?php

use Illuminate\Support\Facades\Route;


//test view
use App\Http\Livewire\FrontEnd\Businesses\ConnectBusinessesView;
use App\Http\Livewire\FrontEnd\Businesses\ConnectBusinessesDetail;


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

Route::middleware('set_layout_frontend')->group(function () {
    // dd(1);

     //Business view
     //Route::get('/businesses/view', ConnectBusinessesView::class)->name('admin.connect.business.view');
     Route::get('/businesses/view/{submenuid}', ConnectBusinessesView::class)->name('connect.business.view');
     //Detail View
     //Route::get('/businesses/view/detail/{}{id}', ConnectBusinessesDetail::class)->name('connect.business.detail');
     Route::get('/businesses/view/detail/{submenuid}/{detailid}', ConnectBusinessesDetail::class)->name('connect.business.detail');

});
// Set admin login
Route::middleware(['check_frontend'])->group(function () {
    //Route::get('/camranh', Welcome::class)->name('welcome');
});

