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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);

Route::view('/template', 'template');

Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
    Route::get('/login', 'login')->middleware(\App\Http\Middleware\OnlyGuestMiddleware::class);
    Route::post('/login', 'doLogin')->middleware(\App\Http\Middleware\OnlyGuestMiddleware::class);
    Route::post('/logout', 'doLogout')->middleware(\App\Http\Middleware\OnlyMemberMiddleware::class);
});

Route::controller(\App\Http\Controllers\TodoListController::class)
    ->middleware(\App\Http\Middleware\OnlyMemberMiddleware::class)
    ->group(function (){
       Route::get('/todolist','todoList');
       Route::post('/todolist','addTodo');
       Route::post('/todolist/{id}/delete','RemoveTodo');
    });
