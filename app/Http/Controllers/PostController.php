<?php

namespace App\Http\Controllers;

use Auth;
use App\Post;
use App\Image;
use App\User;
use App\Category;
use App\Comment;
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

        foreach ($posts as $post) {

            $image = $post->image;

            $data[] = [
                'post_id' => $post->id,
                'user_id' => $post->user_id,
                'category_id' => $post->category_id,
                'user' => $post->user->name,
                'user_full_name' => $post->user->name.' '.$post->user->name_second,
                'category' => $post->category->category,
                'post_content' => $post->post_content,
                'image' => $image
            ];
        }
        
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
        $user_id = Auth::user()->id;;
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

        $comments = $post->comment;

        foreach ($comments as $comment) {
            $comments[] = [
                "comment_id" => $comment['id'],
                "comment_post_id" => $comment['post_id'],
                "comment_user_id" => $comment['user_id'],
                "comment_user" => $comment->user['name'],
                "comment_content" => $comment['comment_content'],
                "created_at" => $comment['created_at'],
                "updated_at" => $comment['updated_at'],
            ];
        }

        $data = [
            'post_id' => $post->id,
            'user_id' => $post->user_id,
            'category_id' => $post->category_id,
            'user' => $post->user->name,
            'category' => $post->category->category,
            'post_content' => $post->post_content,
            'comments' => $comments,
            'image' => $image
        ];

        
        //dd($comment);
        //echo $comment[0]['id'];
        //return $data;
        //return $data;
        return view('page.post-detail')->with('post', $data);
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
    public function postDetail($id)
    {

        echo "string";
        /*$post = Post::find($id);

        $image = $post->image;

        $comments = $post->comment->all();

        foreach ($comments as $comment) {
            $comments[] = [
                "comment_id" => $comment['id'],
                "comment_post_id" => $comment['post_id'],
                "comment_user_id" => $comment['user_id'],
                "comment_user" => $comment->user['name'],
                "comment_content" => $comment['comment_content'],
                "created_at" => $comment['created_at'],
                "updated_at" => $comment['updated_at'],
            ];
        }

        $data_comment = [
            "comment_id" => $comment->id,
            "post_id" => $comment['post_id'],
            "user_id" => $comment['user_id'],
            "user" => $comment->user['name'],
            "comment_content" => $comment['comment_content'],
            "created_at" => $comment['created_at'],
            "updated_at" => $comment['updated_at'],
        ];

        $data = [
            'post_id' => $post->id,
            'user_id' => $post->user_id,
            'category_id' => $post->category_id,
            'user' => $post->user->name,
            'category' => $post->category->category,
            'post_content' => $post->post_content,
            'comments' => $comments,
            'image' => $image
        ];

        
        //dd($comment);
        //echo $comment[0]['id'];
        //return $data;
        //return $data;
        return view('page.post-detail')->with('post', $data);*/

        
    }

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
}
