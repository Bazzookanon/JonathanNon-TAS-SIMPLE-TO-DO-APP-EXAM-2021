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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/task', [App\Http\Controllers\TaskController::class, 'add_task'])->name('posttask');

Route::post('/delete', [App\Http\Controllers\TaskController::class, 'deleteTask'])->name('delete');

Route::post('/donetask', [App\Http\Controllers\TaskController::class, 'donetask'])->name('donetask');

Route::get('/updatetask', [App\Http\Controllers\TaskController::class, 'updatetask'])->name('updatetask');

Route::post('/uptask', [App\Http\Controllers\TaskController::class, 'uptask'])->name('uptask');
