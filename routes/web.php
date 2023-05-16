<?php

use App\Http\Controllers\Apps\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apps\DashboardController;
use App\Http\Controllers\Apps\EmployeesController;
use App\Http\Controllers\Apps\UserController;
use App\Http\Controllers\Apps\RoleController;
use App\Http\Controllers\Apps\TypeReferencesController;
use App\Http\Controllers\Apps\ReferencesController;
use App\Http\Controllers\Apps\GoodsController;
use App\Http\Controllers\Apps\GoodsReceivedController;
use App\Http\Controllers\Apps\OrderGoodsController;
use App\Http\Controllers\Apps\OutgoingGoodsController;

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
        //type references
        Route::resource('/type_references', TypeReferencesController::class, ['as' => 'apps'])
            ->middleware('permission:jenis_referensi.index|jenis_referensi.add|jenis_referensi.edit|jenis_referensi.delete');

        //references
        Route::resource('/references', ReferencesController::class, ['as' => 'apps'])
            ->middleware('permission:referensi.index|referensi.add|referensi.edit|referensi.delete');
        Route::get('/referensi/filter', [ReferencesController::class, 'filter'])->name('apps.references.filter');
        // barang
        Route::resource('/goods', GoodsController::class, ['as' => 'apps'])
            ->middleware('permission:barang.index|barang.add|barang.edit|barang.delete');
        Route::get('barang/historyItem/{id}', [GoodsController::class, 'getItem'])->name('apps.gooods.searchItem');
        Route::post('barang/storeEdit',[GoodsController::class,'storeEdit'])->name('apps.goods.storeEdit');
        // pegawai
        Route::resource('/employees', EmployeesController::class, ['as' => 'apps'])
            ->middleware('permission:pegawai.index|pegawai.add|pegawai.edit|pegawai.delete');
        //perusahaan
        Route::resource('/company', CompanyController::class, ['as' => 'apps'])
            ->middleware('permission:perusahaan.index|perusahaan.add|perusahaan.edit|perusahaan.delete');
        //barang masuk
        Route::post('/barang_masuk/searchGood/', [GoodsReceivedController::class, 'searchGood'])->name('apps.received_goods.search');
        Route::resource('/received_goods', GoodsReceivedController::class, ['as' => 'apps'])
            ->middleware('permission:barang_masuk.index|barang_masuk.add|barang_masuk.edit|barang_masuk.delete');
        Route::get('/barang_masuk/deleteItem/{id}', [GoodsReceivedController::class, 'deleteItem'])->name('apps.received_goods.deleteItem');
        //surat permintaan
        Route::post('/permintaan/searchGood', [OrderGoodsController::class, 'searchGood'])->name('apps.permintaan.search');
        Route::post('/permintaan/approve', [OrderGoodsController::class, 'approve'])->name('apps.permintaan.approve');
        Route::post('/permintaan/notApprove', [OrderGoodsController::class, 'notApprove'])->name('apps.permintaan.notApprove');
        Route::post('/permintaan/hapusBarangPermintaan', [OrderGoodsController::class, 'hapusBarangPermintaan'])->name('apps.permintaan.hapusBarang');
        Route::get('/permintaan/print/', [OrderGoodsController::class, 'print'])->name('apps.permintaan.print');
        Route::resource('/order', OrderGoodsController::class, ['as' => 'apps'])
            ->middleware('permission:order.index|order.add|order.edit|order.delete|order.approval');
        //barang keluar
        Route::resource('/outgoing_goods', OutgoingGoodsController::class, ['as' => 'apps'])
            ->middleware('permission:barang_keluar.index|barang_keluar.approval');
        Route::post('/barang_keluar/approve', [OutgoingGoodsController::class, 'approve'])->name('apps.barang_keluar.approve');
        Route::post('/barang_keluar/notApprove', [OutgoingGoodsController::class, 'notApprove'])->name('apps.barang_keluar.notApprove');
        Route::get('/barang_keluar/inputItem/{id}', [OutgoingGoodsController::class, 'inputItem'])->name('apps.barang_keluar.inputItem');
        Route::post('/barang_keluar/insertItem', [OutgoingGoodsController::class, 'insertItem'])->name('apps.barang_keluar.insertItem');
        Route::post('/barang_keluar/searchSerial/', [OutgoingGoodsController::class, 'searchSerial'])->name('apps.barang_keluar.searchSerial');
        Route::get('/barang_keluar/availableItem/{serial}', [OutgoingGoodsController::class, 'availableItem'])->name('apps.barang_keluar.availableItem');
        //route resource roles
        Route::resource('/roles', RoleController::class, ['as' => 'apps'])
            ->middleware('permission:roles.index|roles.create|roles.edit|roles.delete');
        Route::resource('/users', UserController::class, ['as' => 'apps'])
            ->middleware('permission:user.index|user.create|user.edit|user.delete');
    });
});
