<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    protected $fillable = [
        'post_id', 'user_id', 'comment_content'
    ];

	function user(){
		return $this->belongsTo('App\User');
	}

	function post(){
		return $this->belongsTo('App\Post');
	}
}
