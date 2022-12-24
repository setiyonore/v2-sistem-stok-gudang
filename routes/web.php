<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apps\DashboardController;
use App\Http\Controllers\Apps\UserController;
use App\Http\Controllers\Apps\RoleController;
use App\Http\Controllers\Apps\TypeReferencesController;
use App\Http\Controllers\Apps\ReferencesController;
use App\Http\Controllers\Apps\GoodsController;
use App\Models\Referensi;

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

Route::get('/', function () {
    //    return view('welcome');
    return \Inertia\Inertia::render('Auth/Login');
})->middleware('guest');
//prefix apps
Route::prefix('apps')->group(function () {
    //middleware auth
    Route::group(['middleware' => ['auth']], function () {
        //route dashboard
        Route::get('dashboard', DashboardController::class)->name('apps.dashboard');
    });
    //type references
    Route::resource('/type_references', TypeReferencesController::class, ['as' => 'apps'])
        ->middleware('permission:jenis_referensi.index|jenis_referensi.add|jenis_referensi.edit|jenis_referensi.delete');

    //references
    Route::resource('/references', ReferencesController::class, ['as' => 'apps'])
        ->middleware('permission:referensi.index|referensi.add|referensi.edit|referensi.delete');
    Route::get('/referensi/filter', [ReferencesController::class, 'filter'])->name('apps.references.filter');
    Route::resource('/goods', GoodsController::class, ['as' => 'apps'])
        ->middleware('permission:barang.index|barang.add|barang.edit|barang.delete');
    //route resource roles
    Route::resource('/roles', RoleController::class, ['as' => 'apps'])
        ->middleware('permission:roles.index|roles.create|roles.edit|roles.delete');
    Route::resource('/users', UserController::class, ['as' => 'apps'])
        ->middleware('permission:user.index|user.create|user.edit|user.delete');
});
