<?php

namespace App\Http\Controllers;

use Hash;
use Auth;
use App\User;
use App\Profile;
use App\Post;
use App\Image;
use App\Category;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        $data = [
            'user_id' => $user->user_id,
            'user_name' => $user->name,
            'user_full_name' => $user->name." ".$user->name_second,
            'user_email' => $user->email,
            'user_gender' => $user->profile->gender,
            'user_birth' => $user->profile->date_birth,
            'user_no' => $user->profile->no_hp,
            'user_wa' => $user->profile->no_wa,
            'user_profile_image' => $user->image_profile,
            'user_about' => $user->profile->about,
            'user_provinsi' => $user->profile->provinsi,
            'user_kab_kota' => $user->profile->kab_kota,
            'user_kec' => $user->profile->kecamatan,
            'user_desa' => $user->profile->desa,
            'user_join' => $user->created_at
        ];

        $user_post = Post::where('user_id', '=', $id)->orderBy('created_at', 'DESC')->get();
        $data_post = [];
        


        //$user_post = $user_post->image;

        foreach ($user_post as $post) {

            $image = $post->image;
            $liked = $post->comment->where('user_id', $id)->where('post_id', $post->id)->first();
            $liked = !empty($liked) ? 1 : 0;

            $data_post[] = [
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

        //return $user_post;
        return view('page.profile')
            ->with('user', $data)
            ->with('user_post', $data_post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if(Auth::user()->id != $id){
            //return view('errors.404');
            return response()->view('warning.404');
        }
        return view('page.profile-edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        request()->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' .$id,
            'no_hp' => 'required|string|max:15|unique:user_detail,no_hp, ' .$user->profile->id,
            'no_wa' => 'required|string|max:15|unique:user_detail,no_wa, ' .$user->profile->id
        ]);


        if ($request->new_password == NULL) {

            if($request->file('profile_picture') != NULL){
                // image request input
                $img = $request->file('profile_picture');
                // base path location
                $path = base_path() . '/public/images/profile';
                // naming image
                $image_name = $id.'_'.time().'.'.$img->getClientOriginalExtension();
                // imagepath url
                $imagePath = url('/images/profile').'/'.$image_name;
                // move image to storage
                $img->move($path, $image_name);

                //save to db
                $user->image_profile =$imagePath;
                $user->save();
            }
            
            $user->name = $request->firstname;
            $user->name_second = $request->lastname;
            $user->email = $request->email;
            $user->save();

            $user->profile->update([
                'gender' => $request->gender,
                'date_birth' => $request->date_birth,
                'no_hp' => $request->no_hp,
                'no_wa' => $request->no_wa,
                'about' => $request->about,
                'provinsi' => $request->provinsi,
                'kab_kota' => $request->kab_kota,
                'kecamatan' => $request->kecamatan,
                'user_id' => $id,
                'desa' => $request->desa
            ]);

        } else {

            if(Hash::check($request->old_password, $user->password)) {
                $user->name = $request->firstname;
                $user->name_second = $request->lastname;
                $user->email = $request->email;
                $user->password = bcrypt($request->new_password);
                $user->save();

                $user->profile->update([
                    'gender' => $request->gender,
                    'date_birth' => $request->date_birth,
                    'no_hp' => $request->no_hp,
                    'no_wa' => $request->no_wa,
                    'about' => $request->about,
                    'provinsi' => $request->provinsi,
                    'kab_kota' => $request->kab_kota,
                    'kecamatan' => $request->kecamatan,
                    'user_id' => $id,
                    'desa' => $request->desa
                ]);
            } else {
                return Redirect::back()->withErrors(['Password Lama Salah']);
            }
        }

        return redirect(route('profile.edit', $id))->with('success', 'IT WORKS!');

        //return $request->profile_picture;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profil $profil)
    {
        //
    }
}
