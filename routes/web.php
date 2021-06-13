<?php

use Illuminate\Support\Facades\Route;
use App\Post;

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

// Server side 
Route::get('/home', 'PostController@index')->name('posts.index');
Route::get('/posts/{post}', 'PostController@showpost')->name('posts.showpost');

// Vue
Route::get('/obituary', 'ObituaryController@index')->name('obituary.index');
Route::get('/obituary/{post}', 'ObituaryController@show')->name('obituary.show');

Route::get('/obituary/{post}/comments', 'ObituaryController@showVue')->name('obituary.show');
Route::post('/obituary/saveCondolence', 'ObituaryController@saveCondolence')->name('obituary.show');
Route::post('/obituary/deleteCondolence', 'ObituaryController@deleteCondolence')->name('obituary.show');
