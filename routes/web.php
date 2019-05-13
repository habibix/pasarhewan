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

//Route::get('/home', 'PostController@index')->name('home');
Route::get('/', 'PostController@index')->name('home');

//post
Route::resource('post', 'PostController');

Route::get('post', function(){
	
	$posts = Post::all();

	foreach ($posts as $post) {

		$image = $post->image;

		$data[] = [
			'post_id' => $post->id,
			'user_id' => $post->user_id,
			'category_id' => $post->category_id,
			'user' => $post->user->name,
			'category' => $post->category->category,
			'post_content' => $post->post_content,
			'image' => $image
		];
	}

	//echo count($data['image']);

	foreach ($data as $dat) {
		/*if(count($dat['image']) > 0){
			echo $dat['image'][0]['image']." - ";
			echo $dat['image'][1]['image']."<br>";
			foreach ($dat['image'] as $da) {
				echo $da['image'];
			}
		}*/
		echo $dat['category'];
	}



	//return $data;
	
});
