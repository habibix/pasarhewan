<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
    protected $table = 'image';

    protected $fillable = [
        'post_id', 'image'
    ];

    function post(){
		return $this->belongsTo('App\Post');
	}
}
