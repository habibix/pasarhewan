<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'user_detail';

    protected $fillable = [
        'user_id',
        'gender',
        'date_birth',
        'no_hp',
        'no_wa',
        'about',
        'provinsi',
        'kab_kota',
        'kecamatan',
        'desa',
    ];
}
