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
use App\Like;

/*Route::get('/', function () {
    return view('page.index');
});*/

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

	// POST ROUTE
	Route::resource('post', 'PostController');
	//Route::get('/post/{id}', 'PostController@postDetail')->name('post-detail');
	Route::get('/', 'PostController@index')->name('home');

	// delete post
	Route::post('/post/delete', 'PostController@destroy');

	Route::post('/post/like', 'PostController@like')->name('post-like');
	Route::post('/post/report', 'PostController@report')->name('post-report');

	Route::get('/c', 'PostController@category')->name('category');
	Route::get('/c/{cat}', 'PostController@categoryFilter');

	// Comment
	Route::post('/comment', 'PostController@postComment');

	// Notif
	Route::get('/notifications', 'NotificationController@index');
	Route::get('/notifications/{notif}', 'NotificationController@notifications');
	//Route::get('/notif/{what}', 'PostController@showNotifications');

	// PROFILE ROUTE
	Route::resource('profile', 'ProfilController');

});


/*Route::get('/test', function(){
	$year = date('Y');
    $month = date('m');
	$path = base_path() . '/public/images/'.$year.'/'.$month.'/';
	if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777,true);
                }   
});*/
//Route::get('/profile/{id}', 'ProfilController@profile')->name('profile');
//Route::get('/profile/edit/{id}', 'ProfilController@editProfile')->name('edit-profile');

// TEST
