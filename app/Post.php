<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';

    protected $fillable = [
        'user_id', 'category_id', 'post'
    ];

    public static function insertPost($postdata)
	{
	    $post = new Post;
	    $post->fill($postdata);
	    $post->save();
	    return $post->id;
	}

	function user(){
		return $this->belongsTo('App\User');
	}

	function category(){
		return $this->belongsTo('App\Category');
	}
}
