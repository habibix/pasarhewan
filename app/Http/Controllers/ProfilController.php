<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use App\Post;
use App\Image;
use App\Category;
use App\Comment;
use Illuminate\Http\Request;

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
        /*$user = User::find($id);

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

        $user_post = $user->post;

        foreach ($user_post as $post) {

            $image = $user_post->image;

            $data_post[] = [
                'post_id' => $post->id,
                'user_id' => $post->user_id,
                'category_id' => $post->category_id,
                'user' => $post->user->name,
                'category' => $post->category->category,
                'post_content' => $post->post_content,
                'image' => $image
            ];
        }

        //return $data;
        return view('page.profile')
            ->with('user', $data)
            ->with('user_post', $data_post);*/
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
            'user_about' => $user->profile->about,
            'user_provinsi' => $user->profile->provinsi,
            'user_kab_kota' => $user->profile->kab_kota,
            'user_kec' => $user->profile->kecamatan,
            'user_desa' => $user->profile->desa,
            'user_join' => $user->created_at
        ];

        $user_post = Post::where('user_id', '=', $id)->orderBy('created_at', 'DESC')->get();

        //$user_post = $user_post->image;

        foreach ($user_post as $post) {

            $image = $post->image;

            $data_post[] = [
                'post_id' => $post->id,
                'user_id' => $post->user_id,
                'category_id' => $post->category_id,
                'user' => $post->user->name,
                'category' => $post->category->category,
                'post_content' => $post->post_content,
                'image' => $image
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
            'lastname' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' .$id,
            'no_hp' => 'required|string|max:15|unique:user_detail,no_hp, ' .$user->profile->id,
        ]);


        if ($request->password == NULL) {
            
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
                'user_id' => $request->user_id,
                'desa' => $request->desa
            ]);

        } else {
            $user->name = $request->name;
            $user->name_second = $request->name_second;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
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
                'user_id' => $request->user_id,
                'desa' => $request->desa
            ]);
        }

        notify()->flash('Done!', 'success', [
            'timer' => 1500,
            'text' => 'Member successfully Edited',
        ]);

        //return redirect()->back();
        return redirect(route('profile.edit', compact($id)))->withErrors($validator);
        //
        echo "string";
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
