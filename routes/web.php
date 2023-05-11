<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'importFormXLSX')->middleware('auth.basic');
Route::post('/uploadFile', [App\Http\Controllers\UploadExcelFileController::class, 'uploadFile'])->middleware('auth.basic');
Route::get('/rows', [App\Http\Controllers\DisplayRowsController::class, 'index']);
Route::get('/userID', function(){ return Auth::id(); });

