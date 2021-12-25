<?php

use App\Http\Controllers\CategoryController;
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
    return view('frontEnd.pages.home');
})->name('frontEnd.home');

Route::get('/post', function () {
    return view('frontEnd.pages.post');
});


// category routes


Route::get('/category', function () {
    return view('frontEnd.pages.category');
});



Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::resource('category', 'App\Http\Controllers\CategoryController');
    Route::resource('tag', 'App\Http\Controllers\TagController');
    Route::resource('post', 'App\Http\Controllers\PostController');
});



// admin panel routes

Route::get('/admin', function () {
    return view('backEnd.pages.dashboard.dashboard');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
