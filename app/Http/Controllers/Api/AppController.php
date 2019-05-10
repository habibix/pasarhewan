<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    //

public function __construct()
    {

    }

public function appVersion()
    {
        return response()->json([
           'status' => 200,
           'version' => 1,
        ]);
    }
}
