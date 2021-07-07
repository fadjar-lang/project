<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('data.index', [PegawaiController::class, 'index'])->name('data');
Route::post('data.store', [PegawaiController::class, 'store'])->name('store');
Route::post('data.edit', [PegawaiController::class, 'edit'])->name('edit');
Route::post('data.update', [PegawaiController::class, 'update'])->name('update');
Route::post('data.hapus', [PegawaiController::class, 'destroy'])->name('hapus');