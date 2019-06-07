<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Storage;
use Image;
use File;

use App\Post;
use App\ImageModel;
use App\User;
use App\Category;
use App\Comment;
use App\Like;
use App\Report;
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

    public function timeAgo ( $time_ago ) {
        $time_ago       = strtotime($time_ago);
        $cur_time       = time();
        $time_elapsed   = $cur_time - $time_ago;
        $seconds        = $time_elapsed ;
        $minutes        = round($time_elapsed / 60 );
        $hours          = round($time_elapsed / 3600);
        $days           = round($time_elapsed / 86400 );
        $weeks          = round($time_elapsed / 604800);
        $months         = round($time_elapsed / 2600640 );
        $years          = round($time_elapsed / 31207680 );
        // Seconds
        if($seconds <= 60){
            return "just now";
        }
        //Minutes
        else if($minutes <=60){
            if($minutes==1){
                return "one minute ago";
            }
            else{
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if($hours <=24){
            if($hours==1){
                return "an hour ago";
            }else{
                return "$hours hrs ago";
            }
        }
        //Days
        else if($days <= 7){
            if($days==1){
                return "yesterday";
            }else{
                return "$days days ago";
            }
        }
        //Weeks
        else if($weeks <= 4.3){
            if($weeks==1){
                return "a week ago";
            }else{
                return "$weeks weeks ago";
            }
        }
        //Months
        else if($months <=12){
            if($months==1){
                return "a month ago";
            }else{
                return "$months months ago";
            }
        }
        //Years
        else{
            if($years==1){
                return "one year ago";
            }else{
                return "$years years ago";
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        //$posts = Post::paginate(5);

        $categories = Category::all();
        $posts = Post::orderBy('created_at', 'DESC')->paginate(10);
        $user_id = Auth::user()->id;

        $paginate = [
            'last_page'=> $posts->lastPage(),
            'total'=> $posts->total()
        ];

        $data = [];

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
                'time' => $this->timeAgo($post->created_at),
                'image' => $image,
                'liked' => $liked
            ];
        }

        if ($request->ajax()) {
            $view = view('page.fetch-data', compact('data'))->render();
            //$view = view('page.fetch-data')->with('posts', $data)->render();
            return response()->json(['html' => $view]);
        }

        //return $data;
        
        return view('page.index')
            ->with('paginate', $paginate)
            ->with('posts', $data)->with('categories', $categories);
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
        $posts = Post::where('category_id', $cat_id->id)->orderBy('created_at', 'DESC')->paginate(10);
        $user_id = Auth::user()->id;

        $paginate = [
            'last_page'=> $posts->lastPage(),
            'total'=> $posts->total()
        ];

        $data = [];
        

        if(count($posts) > 0){
            foreach ($posts as $post) {

                $liked = $post->comment->where('user_id', $user_id)->where('post_id', $post->id)->first();
                $liked = !empty($liked) ? 1 : 0;
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
                    'time' => $this->timeAgo($post->created_at),
                    'image' => $image,
                    'liked' => $liked
                ];
            
            }

            //return $data;
            
            return view('page.index')
                ->with('posts', $data)
                ->with('title', "Kategori ".ucfirst($cat))
                ->with('paginate', $paginate)
                ->with('categories', $categories);

        } else {

            return view('page.index')
                ->with('paginate', $paginate)
                ->with('title', "Kategori ".ucfirst($cat))
                ->with('categories', $categories);
        }

        if ($request->ajax()) {
            $view = view('page.fetch-data', compact('data'))->render();
            return response()->json(['html' => $view]);
        }
    }

    /*public function fetch_data(Request $request){
        
    }*/

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
    public function store(Request $request) {

        //new
        /*if ($request->hasFile('post_image')) {
 
            foreach($request->file('post_image') as $file){
     
                //get filename with extension
                $filenamewithextension = $file->getClientOriginalName();
     
                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
     
                //get file extension
                $extension = $file->getClientOriginalExtension();
     
                //filename to store
                $filenametostore = $filename.'_'.uniqid().'.'.$extension;

                // image name mod
                $image_name = $user_id.'_'.$category_id.'_'.time().'_'.$num.'.'.$img->getClientOriginalExtension();
     
                $img->move($path, $image_name);

                Storage::put('public/uploads/'. $filenametostore, fopen($file, 'r+'));
                Storage::put('public/images/'. $filenametostore, fopen($file, 'r+'));
     
                //Resize image here
                $thumbnailpath = 'public/uploads/'.$filenametostore;
                $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($thumbnailpath);
            }
     
            //return redirect('images')->with('status', "Image uploaded successfully.");
            return "ok";
        }*/
        //end

        $validator = Validator::make($request->all(), [
            'post_category' => 'required',
            'post_text' => 'required_without_all:post_image',
            'post_image' => 'required_without_all:post_text|max:6144',
            'post_image.*' => 'image|mimes:jpeg,png,jpg|max:6144'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        //retriving data
        $user_id = Auth::user()->id;
        $category_id = $request->post_category;
        $year = date('Y');
        $month = date('m');
        $path = base_path() . '/public/uploads/'.$year.'/'.$month.'/';
        $thumbnailpath = $path.'thumbnail/';

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
            if(count($images) > 3) {
                //return back()->with('error', 'Failed to find that resource');
                return Redirect::back()->withErrors(['Sementara upload tidak lebih 3 file']);
            }

            $num = 0;
            //retriving post images
            foreach ($images as $image => $img) {

                //naming image
                $image_name = $user_id.'_'.$category_id.'_'.time().'_'.$num.'.'.strtolower($img->getClientOriginalExtension());
                
                // create directory if not exist
                if (!File::isDirectory($thumbnailpath)) {
                    File::makeDirectory($thumbnailpath);
                }

                // initialize image
                $img_compres = Image::make($img);

                if($img_compres->width() > 960){
                    $img_compres->resize(960, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path.$image_name, 80);
                } else {
                    // intervension image compress save to storage
                    $img_compres->save($path.$image_name, 60);
                }

                // generate thumbnail save to storage
                $img_compres->resize(200, 200)->save($thumbnailpath.$image_name, 80);

                // save aspect ratio
                /*$img_compres->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbnailpath.$image_name, 80);*/

                //move image to storage (real image)
                //$img->move($path, $image_name); // original system upload
                
                //retriving imag data
                $dataimage = array (
                    'post_id'       => $post_id,
                    'image'         => $year.'/'.$month.'/'.$image_name,
                );

                //post image
                ImageModel::create($dataimage);

                $num++;
            }
        }
    
        //return $mime;
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

            return view('page.post-detail')
                ->with('title', $post->user->name." ".$post->user->name_second)
                ->with('post', $data);

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

            return view('page.post-detail')
                ->with('title', $post->user->name)
                ->with('post', $data);
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
    public function destroy(Request $request)
    {
        $post = Post::findOrFail($request->post_id);

        if($post->user_id == Auth::user()->id){
            $post = $post->delete();
            if($post) {
                return response()->json([
                    'status' => 200,
                    'data' => $post,
                    'message' => 'success'
                ]);
            }
        }
        
        /*if(!User::destroy($id)) return redirect()->back();
        return redirect()->route('page.index');*/
    }

    
    /**
     * Show post detail and comment
     *
     * @param post_id
     */

    /*public function profile($id){

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
    }*/

    

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
    public function notifications ( $notif ){

        $user_id = Auth::user()->id;

        $notifications = DB::table('comment')
            ->join('users', 'users.id', '=', 'comment.user_id')
            ->join('post', 'post.id', '=', 'comment.post_id')
            ->where('post.user_id', '=', $user_id)
            ->where('comment.user_id', '!=', $user_id)
            ->select('comment.*', 'post.id', 'users.name', 'users.name_second', 'users.image_profile')
            ->get();

        $data = [];

        foreach ($notifications as $notification) {

            $data[] = [
                'id'=> $notification->id,
                'post_id'=> $notification->post_id,
                'user_id'=> $notification->user_id,
                'comment_content'=> $notification->comment_content,
                'comment_status'=> $notification->comment_status,
                'comment_type'=> $notification->comment_type,
                'name'=> $notification->name,
                'name_second'=> $notification->name_second,
                'image_profile'=> $notification->image_profile,
                'created_at'=> $this->timeAgo($notification->created_at),
                'updated_at'=> $notification->updated_at
            ];
        }

        switch ($notif) {
            case 'all':

                return view('page.notifications')
                    ->with('notifications', $data);
                break;

            case 'notification-count':

                $notif_count = $notifications
                    ->where('comment.comment_status', '=', 0);

                return count($notif_count);
                break;
            case 'notification-list':            



                return $notif;
                break;

            case 'notification-list':  
                
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
            ->with('notifications', $data);*/

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

    public function report(Request $request){

            $report = Report::create([
                'user_id' => Auth::user()->id,
                'post_id' => $request->post_id,
                'detail' => $request->detail
            ]);

        /*if($report){
            return response()->json([
                'status' => 200,
                'data' => null,
                'message' => 'success'
            ]);
        }*/


    }

}