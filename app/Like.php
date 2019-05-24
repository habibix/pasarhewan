<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'post_like';

    protected $fillable = [
        'post_id', 'user_id'
    ];

    function post(){
		return $this->belongsTo('App\Post');
	}

	function user(){
		return $this->belongsTo('App\User');
	}
}
