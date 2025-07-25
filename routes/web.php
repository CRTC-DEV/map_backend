<?php

use App\Http\Livewire\Web\AdminDashboard;
use App\Http\Livewire\Auth\AdminLogin;
use App\Http\Livewire\Web\AdminInformation;

use App\Http\Livewire\Web\ConnectBusinesses\ConnectBusinessesDetailLive;
use App\Http\Livewire\Web\ConnectBusinesses\ConnectBusinessesLive;
use App\Http\Livewire\Web\ConnectBusinesses\ConnectBusinessesAddLive;


use Illuminate\Support\Facades\Route;
use OpenApi\Attributes\Webhook;

use App\Http\Livewire\Web\Admin\WebAdminManagement;
use App\Http\Livewire\Web\Admin\WebAdminManagementAdd;
use App\Http\Livewire\Web\Admin\WebAdminManagementDetail;

use App\Http\Livewire\Map\TextContent\TextContentListLive;
use App\Http\Livewire\Map\TextContent\TextContentAddLive;
use App\Http\Livewire\Map\TextContent\TextContentDetailLive;

use App\Http\Livewire\Map\Languages\LanguagesListLive;
use App\Http\Livewire\Map\Languages\LanguagesAddLive;
use App\Http\Livewire\Map\Languages\LanguagesDetailLive;

use App\Http\Livewire\Map\Translations\TranslationsListLive;
use App\Http\Livewire\Map\Translations\TranslationsAddLive;
use App\Http\Livewire\Map\Translations\TranslationsDetailLive;

use App\Http\Livewire\Map\ItemTitle\ItemTitleLive;
use App\Http\Livewire\Map\ItemTitle\ItemTitleAddLive;
use App\Http\Livewire\Map\ItemTitle\ItemTitleDetailLive;

use App\Http\Livewire\Map\ItemDescription\ItemDescriptionLive;
use App\Http\Livewire\Map\ItemDescription\ItemDescriptionAddLive;
use App\Http\Livewire\Map\ItemDescription\ItemDescriptionDetailLive;

use App\Http\Livewire\Web\SubMenu\SubMenuAddLive;
use App\Http\Livewire\Web\SubMenu\SubMenuDetailLive;
use App\Http\Livewire\Web\SubMenu\SubMenuLive;

use App\Http\Livewire\Web\TopMenu\TopMenuAddLive;
use App\Http\Livewire\Web\TopMenu\TopMenuDetailLive;
use App\Http\Livewire\Web\TopMenu\TopMenuLive;

use App\Http\Livewire\Web\SubmenuOnTopmenu\SubmenuOnTopmenuAddLive;
use App\Http\Livewire\Web\SubmenuOnTopmenu\SubmenuOnTopmenuDetailLive;
use App\Http\Livewire\Web\SubmenuOnTopmenu\SubmenuOnTopmenuLive;

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

Route::middleware('set_layout_admin')->group(function () {
    Route::redirect('/admin', 'web-login');
    Route::redirect('/web', 'web-login');
    Route::get('/web-login', AdminLogin::class)->name('admin.login');
});
Route::middleware(['admin'])->group(function () {
    // Route cho tất cả các vai trò
    Route::get('/admin-dashboard', AdminDashboard::class)->name('admin-dashboard');
    Route::get('/admin-profile', AdminInformation::class)->name('admin.profile');

    // Route cho admin và staff
    Route::middleware(['role:staff|admin'])->group(function () {

        //Business Connect
        Route::get('/connect-businesses', ConnectBusinessesLive::class)->name('admin.connect.business');
        Route::get('/connect-businesses-add', ConnectBusinessesAddLive::class)->name('admin.connect.business.add');
        Route::get('/connect-businesses-edit/{id}', ConnectBusinessesDetailLive::class)->name('admin.connect.business.edit');
    });


    // Route chỉ dành cho admin
    Route::middleware(['role:admin'])->group(function () {
        // Text Content
        Route::get('/web-text-content', TextContentListLive::class)->name('admin.text-content');
        Route::get('/web-text-content-add', TextContentAddLive::class)->name('admin.text-content-add');
        Route::get('/web-text-content-edit/{id}', TextContentDetailLive::class)->name('admin.text-content-edit');

        // Language
        Route::get('/web-languages', LanguagesListLive::class)->name('admin.languages');
        Route::get('/web-languages-add', LanguagesAddLive::class)->name('admin.languages-add');
        Route::get('/web-languages-edit/{id}', LanguagesDetailLive::class)->name('admin.languages-edit');

        // Translation
        Route::get('/web-translations', TranslationsListLive::class)->name('admin.translations');
        Route::get('/web-translations-add', TranslationsAddLive::class)->name('admin.translations-add');
        Route::get('/web-translations-edit/{id}', TranslationsDetailLive::class)->name('admin.translations-edit');

        // Item Title
        Route::get('/title', ItemTitleLive::class)->name('admin.title');
        Route::get('/title-add', ItemTitleAddLive::class)->name('admin.title-add');
        Route::get('/title-edit/{id}', ItemTitleDetailLive::class)->name('admin.title-edit');

        // Item Description
        Route::get('/description', ItemDescriptionLive::class)->name('admin.description');
        Route::get('/description-add', ItemDescriptionAddLive::class)->name('admin.description-add');
        Route::get('/description-edit/{id}', ItemDescriptionDetailLive::class)->name('admin.description-edit');

        //Top Menu
        Route::get('/topmenu', TopMenuLive::class)->name('admin.topmenu');
        Route::get('/topmenu-add', TopMenuAddLive::class)->name('admin.topmenu.add');
        Route::get('/topmenu-edit/{id}', TopMenuDetailLive::class)->name('admin.topmenu.edit');

        //Sub Menu
        Route::get('/submenu', SubMenuLive::class)->name('admin.submenu');
        Route::get('/submenu-add', SubMenuAddLive::class)->name('admin.submenu.add');
        Route::get('/submenu-edit/{id}', SubMenuDetailLive::class)->name('admin.submenu.edit');

        //SubMenu On TopMenu
        Route::get('/submenuontopmenu', SubmenuOnTopmenuLive::class)->name('admin.submenuontopmenu');
        Route::get('/submenuontopmenu-add', SubmenuOnTopmenuAddLive::class)->name('admin.submenuontopmenu.add');
        Route::get('/submenuontopmenu-edit/{id}', SubmenuOnTopmenuDetailLive::class)->name('admin.submenuontopmenu.edit');
        
        // manage user
        Route::get('/web-admin-management', WebAdminManagement::class)->name('admin.web');
        Route::get('/web-admin-management-add', WebAdminManagementAdd::class)->name('admin.web.add');
        Route::get('/web-admin-management-edit/{id}', WebAdminManagementDetail::class)->name('admin.web.edit');
    });
});
