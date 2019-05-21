<?php

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

use App\Post;

/*Route::get('/', function () {
    return view('page.index');
});*/

Auth::routes();

// POST ROUTE
Route::resource('post', 'PostController');
Route::get('/post/{id}', 'PostController@postDetail')->name('post-detail');
Route::get('/', 'PostController@index')->name('home');

Route::get('/c', 'PostController@category')->name('category');
Route::get('/c/{cat}', 'PostController@categoryFilter');

// Comment
Route::post('/comment', 'PostController@postComment');

// Notif
Route::get('/notifications', 'PostController@notifications');
Route::get('/notif/{what}', 'PostController@showNotifications');

// PROFILE ROUTE
Route::resource('profile', 'ProfilController');
//Route::get('/profile/{id}', 'ProfilController@profile')->name('profile');
//Route::get('/profile/edit/{id}', 'ProfilController@editProfile')->name('edit-profile');

// TEST
