<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CommentController;

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

Route::get('/', function () {
    return redirect(route('posts.index'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('posts', PostController::class)->middleware('auth');

Route::resource('clubs', ClubController::class)->middleware('auth');

Route::resource('users', UserController::class)->middleware('auth');

Route::resource('comments', CommentController::class)->middleware('auth');

Route::post('/follow/{user}', [UserController::class, 'follow'])->name('follow')->middleware('auth');