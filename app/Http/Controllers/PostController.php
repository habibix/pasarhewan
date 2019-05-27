<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Post;
use App\Image;
use App\User;
use App\Category;
use App\Comment;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = Category::all();
        $posts = Post::orderBy('created_at', 'DESC')->get();
        $user_id = Auth::user()->id;

        foreach ($posts as $post) {

            $image = $post->image;
            $liked = $post->comment->where('user_id', $user_id)->where('post_id', $post->id)->first();
            $liked = !empty($liked) ? 1 : 0;

            $data[] = [
                'post_id' => $post->id,
                'user_id' => $post->user_id,
                'category_id' => $post->category_id,
                'user' => $post->user->name,
                'profile_image' => $post->user->image_profile,
                'user_full_name' => $post->user->name.' '.$post->user->name_second,
                'category' => $post->category->category,
                'post_content' => $post->post_content,
                'image' => $image,
                'liked' => $liked
            ];
        }

        //return $data;
        
        return view('page.index')
            ->with('posts', $data)
            ->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'post_category' => 'required',
            'post_text' => 'required_without_all:post_image',
            'post_image' => 'required_without_all:post_text'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        //retriving data
        $user_id = Auth::user()->id;
        $category_id = $request->post_category;
        $path = base_path() . '/public/uploads/';

        //get post data
        $data = array(
            'user_id'       => $user_id,
            'post_content'  => $request->post_text,
            'category_id'   => $category_id
        );

        //insert post data
        $post_id = Post::insertPost($data);
     
        //get post images
        $images = $request->file('post_image');

        if(!empty($images)){
            if(count($images) > 2) {
                //return back()->with('error', 'Failed to find that resource');
                return Redirect::back()->withErrors(['Sementara upload tidak lebih 2 file']);
            }

            $num = 0;
            //retriving post images
            foreach ($images as $image => $img) {

                //naming image
                $image_name = $user_id.'_'.$category_id.'_'.time().'_'.$num.'.'.$img->getClientOriginalExtension();

                //move image to storage
                $img->move($path, $image_name);

                //retriving imag data
                $dataimage = array (
                    'post_id'       => $post_id,
                    'image'         => $image_name,
                );

                //post image
                Image::create($dataimage);

                $num++;
            }
        }
    

        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $image = $post->image;
        $comments = $post->comment->where('comment_type', 'comment');

        $user_id = Auth::user()->id;

        $liked = $post->comment->where('user_id', $user_id)
            ->where('post_id', $id)
            ->first();
        $liked = !empty($liked) ? 1 : 2;

        foreach ($comments as $comment) {
            $commentss[] = [
                "comment_id" => $comment['id'],
                "comment_post_id" => $comment['post_id'],
                "comment_user_id" => $comment['user_id'],
                "comment_user_picture" => $comment->user->image_profile,
                "comment_user" => $comment->user['name']." ".$comment->user['name_second'],
                "comment_content" => $comment['comment_content'],
                "created_at" => $comment['created_at'],
                "updated_at" => $comment['updated_at'],
            ];
        }

        if(count($comments) > 0){
            $data = [
                'post_id' => $post->id,
                'user_id' => $post->user_id,
                'category_id' => $post->category_id,
                'user' => $post->user->name." ".$post->user->name_second,
                'category' => $post->category->category,
                'post_content' => $post->post_content,
                'profile_image' => $post->user->image_profile,
                'comments' => $commentss,
                'image' => $image,
                'liked' => $liked
            ];

            return view('page.post-detail')->with('post', $data);

        } else {
            $data = [
                'post_id' => $post->id,
                'user_id' => $post->user_id,
                'category_id' => $post->category_id,
                'user' => $post->user->name,
                'category' => $post->category->category,
                'post_content' => $post->post_content,
                'profile_image' => $post->user->image_profile,
                'comments' => [],
                'image' => $image,
                'liked' => $liked
            ];

            return view('page.post-detail')->with('post', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(post $post)
    {
        //
    }

    
    /**
     * Show post detail and comment
     *
     * @param post_id
     */

    public function profile($id){

        $user = User::find($id);

        $data = [
            'user_id' => $user->user_id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_gender' => $user->profile->gender,
            'user_birth' => $user->profile->date_birth,
            'user_no' => $user->profile->no_hp,
            'user_wa' => $user->profile->no_wa,
            'user_about' => $user->profile->about,
            'user_provinsi' => $user->profile->provinsi,
            'user_kab_kota' => $user->profile->kab_kota,
            'user_kec' => $user->profile->kecamatan,
            'user_desa' => $user->profile->desa,
            'user_join' => $user->created_at
        ];

        //return $data;
        return view('page.profile')
            ->with('user', $data);
    }

    public function category(){
        $categories = Category::all();
        
        return view('page.category')
            ->with('categories', $categories);
    }

    public function categoryFilter($cat){

        $categories = Category::all();
        $cat = strtolower($cat);
        $cat_id = Category::where('category', $cat)->first();
        $posts = Post::where('category_id', $cat_id->id)->orderBy('created_at', 'DESC')->get();
        

        if(count($posts) > 0){
            foreach ($posts as $post) {

                $image = $post->image;

                $data[] = [
                    'post_id' => $post->id,
                    'user_id' => $post->user_id,
                    'category_id' => $post->category_id,
                    'user' => $post->user->name,
                    'profile_image' => $post->user->image_profile,
                    'user_full_name' => $post->user->name.' '.$post->user->name_second,
                    'category' => $post->category->category,
                    'post_content' => $post->post_content,
                    'image' => $image
                ];
            
            }

            //return $data;
            
            return view('page.index')
                ->with('posts', $data)
                ->with('categories', $categories);

        } else {

            return view('page.index')
            ->with('categories', $categories);
        }
    }

    public function postComment(Request $request){

        if(Auth::user()->id == $request->user_id){

            $validator = Validator::make($request->all(), [
                'comment_content' => 'required'
            ]);

            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }
            //retriving imag data
            $comment = array (
                'post_id' => $request->post_id,
                'user_id' => $request->user_id,
                'comment_content' => $request->comment_content,
                'comment_type' => 'comment',
            );

            //post image
            $com = Comment::create($comment);

            return redirect('post/'.$request->post_id);
        }

    }

    //notif
    public function notifications(){

        $user_id = Auth::user()->id;

        $comments = DB::table('comment')
            ->join('users', 'users.id', '=', 'comment.user_id')
            ->join('post', 'post.id', '=', 'comment.post_id')
            ->where('post.user_id', '=', $user_id)
            ->where('comment.user_id', '!=', $user_id)
            ->select('comment.*', 'post.id', 'users.name', 'users.name_second', 'users.image_profile')
            ->get();

        //return $comments;

        return view('page.notifications')
            ->with('comments', $comments);
    }

    public function showNotifications($what){

        $user_id = Auth::user()->id;
        //select * from post, comment WHERE comment.post_id=post.id AND post.user_id=1 AND comment.user_id != 1

        $notif = DB::table('comment')
            ->join('users', 'users.id', '=', 'comment.user_id')
            ->join('post', 'post.id', '=', 'comment.post_id')
            ->where('post.user_id', '=', $user_id)
            ->where('comment.user_id', '!=', $user_id)
            ->where('comment.comment_status', '=', 0)
            ->select('comment.*', 'post.id', 'users.name', 'users.name_second')
            ->get();

            /*foreach ($comments as $comment) {
                $com[] = [
                    'id'=> $comment->id,
                    'post_id'=> $comment->post_id,
                    'user_id'=> $comment->user_id,
                    'comment_content'=> $comment->comment_content,
                    'comment_status'=> $comment->comment_status,
                    'created_at'=> $comment->created_at,
                    'updated_at'=> $comment->updated_at
                ];
            }*/

        switch ($what) {
            case 'nc':

                $notif = DB::table('comment')
                    ->join('users', 'users.id', '=', 'comment.user_id')
                    ->join('post', 'post.id', '=', 'comment.post_id')
                    ->where('post.user_id', '=', $user_id)
                    ->where('comment.user_id', '!=', $user_id)
                    ->where('comment.comment_status', '=', 0)
                    ->select('comment.*', 'post.id', 'users.name', 'users.name_second')
                    ->get();

                return count($notif);
                break;
            
            case 'nl':            

                $notif = DB::table('comment')
                    ->join('users', 'users.id', '=', 'comment.user_id')
                    ->join('post', 'post.id', '=', 'comment.post_id')
                    ->where('post.user_id', '=', $user_id)
                    ->where('comment.user_id', '!=', $user_id)
                    ->select('comment.*', 'post.id', 'users.name', 'users.name_second', 'users.image_profile')
                    ->limit(5)
                    ->get();

                return $notif;
                break;

            case 'cn':  
                
                $update_status = array(
                    'comment_status' => 1
                );
                
                $notif = DB::table('comment')
                    ->join('users', 'users.id', '=', 'comment.user_id')
                    ->join('post', 'post.id', '=', 'comment.post_id')
                    ->where('post.user_id', '=', $user_id)
                    ->where('comment.user_id', '!=', $user_id)
                    ->where('comment.comment_status', '=', 0)
                    ->select('comment.*', 'post.id', 'users.name', 'users.name_second')
                    ->update($update_status);
            
                break;
        }

        /*return view('page.notifications')
            ->with('comments', $comments);*/
    }

    public function like(Request $request){

        $user_id = Auth::user()->id;
        $post_id = $request->post_id;
        //$post_id = str_replace('post-', '', $request->post_id);

        //$like = Like::where('post_id', $post_id)->where('user_id', $user_id)->first();

        $like = Comment::where('post_id', $post_id)
            ->where('comment_type', 'like')
            ->where('user_id', $user_id)
            ->first();
        
        if(!empty($like)){

            $like->delete();

            return response()->json([
                'status' => 200,
                'data' => $like,
                'liked' => 1,
                'message' => 'success'
            ]);

        } else {

            try {
                $data = Comment::create([
                    'post_id' => $post_id,
                    'user_id' => Auth::user()->id,
                    'comment_content' => 'like',
                    'comment_status' => 0,
                    'comment_type' => 'like'
                ]);

                return response()->json([
                    'status' => 200,
                    'data' => $data,
                    'liked' => 0,
                    'message' => 'success'
                ]);

            } catch (Exception $e) {
                return response()->json([
                    'status' => 500,
                    'data' => null,
                    'message' => 'failed'
                ]);
            }

            return $like;
        }
    }

}
