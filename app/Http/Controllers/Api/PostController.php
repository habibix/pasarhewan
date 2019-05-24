<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use JWTAuth;
use JWTAuthException;

use App\User;
use App\Profile;
use App\Post;
use App\Image;
use App\Like;
use App\Comment;

class PostController extends Controller
{
    //

    public function __construct()
    {
        $this->post = new Post();
    }

    public function post(Request $request) {
    	try {
            $user = JWTAuth::toUser($request->token);

            $data = Post::create([
                'user_id' => $request['user_id'],
                'category_id' => $request['category_id'],
                'post_content' => $request['post_content']
            ]);

            return response()->json([
                'status' => 200,
                'data' => $data,
                'message' => 'Post is_success'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function like(Request $request){

        try {
            $user = JWTAuth::toUser($request->token);

            $like = array (
                'post_id' => $request['post_id'],
                'user_id' => $request['user_id']
            );
            
            $like = Like::create($like);

            return response()->json([
                'status' => 200,
                'data' => $like,
                'message' => 'success'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
        
    }
}
