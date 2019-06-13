<?php

$path = Config('app.url') . '/images/post';
$path_thumbnail = Config('app.url') . '/images/thumbnail';
$path_profile = Config('app.url') . '/images/profile';

return [

    /*
    |--------------------------------------------------------------------------
    | User Defined Variables
    |--------------------------------------------------------------------------
    |
    | This is a set of variables that are made specific to this application
    | that are better placed here rather than in .env file.
    | Use config('your_key') to get the values.
    |
    */

    'image_dir' => env('IMAGE_DIR', $path),
    'profile_dir' => env('IMAGE_DIR', $path_profile),
    'thumbnail_dir' => env('THUMBNAIL_DIR', $path_thumbnail),

];