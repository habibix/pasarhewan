<?php

namespace App\Http\Controllers;

use Auth;
use App\Post;
use App\Image;
use App\User;
use App\Category;
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
        $posts = Post::all();

        foreach ($posts as $post) {

            $image = $post->image;

            $data[] = [
                'post_id' => $post->id,
                'user_id' => $post->user_id,
                'category_id' => $post->category_id,
                'user' => $post->user->name,
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

        $request->validate([
            'post_category' => 'required',
        ]);

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
    

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(post $post)
    {
        //
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
}
