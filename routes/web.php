<?php

use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('find');
}); */

Route::get('/', [\App\Http\Controllers\FindController::class, 'find'])->name('find');
Route::post('/', [\App\Http\Controllers\FindController::class, 'find'])->name('find');
