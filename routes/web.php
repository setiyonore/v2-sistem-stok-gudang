<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apps\DashboardController;

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
Route::prefix('apps')->group(function (){
    //middleware auth
    Route::group(['middleware' => ['auth']],function (){
        //route dashboard
        Route::get('dashboard',DashboardController::class)->name('apps.dashboard');
    });
});
