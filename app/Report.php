<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'report_post';

    protected $fillable = [
        'user_id', 'post_id', 'detail'
    ];
}
