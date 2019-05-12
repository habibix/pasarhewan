<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use JWTAuth;
use JWTAuthException;
use App\User;
use App\Profile;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->user = new User();
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'data' => null,
                'message' => 'Data Tidak Lengkap'
            ]);
        }

        $data = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role' => 'member'
        ]);

        $credentials = [
            'email' => $request['email'],
            'password' => $request['password']
        ];

        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 500,
                    'data' => null,
                    'message' => 'Email atau Password Salah',
                ]);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => 'failed_to_create_token',
            ]);
        }

        return response()->json([
            'status' => 200,
            'message'=>'User created successfully',
            'data' => [
                'token' => $token,
                'user' => $data
            ],
        ]);
    }

    public function registerDetail(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);

            $data = Profile::create([
                'user_id' => $request['user_id'],
                'gender' => $request['gender'],
                'date_birth' => $request['date_birth'],
                'no_hp' => $request['no_hp'],
                'no_wa' => $request['no_wa'],
                'about' => $request['about'],
                'provinsi' => $request['provinsi'],
                'kab_kota' => $request['kab_kota'],
                'kecamatan' => $request['kecamatan'],
                'desa' => $request['desa']
            ]);

            return response()->json([
                'status' => 200,
                'data' => $data,
                'message' => 'update sukses'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 500,
                    'data' => null,
                    'message' => 'Email atau Password Salah',
                ]);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => 'failed_to_create_token',
            ]);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'status' => 200,
            'message'=>'User login successfully',
            'data' => [
                'token' => $token,
                'user' => $user
            ],
        ]);
    }

    public function refreshToken(){
        $token = JWTAuth::parseToken()->refresh();
        return response()->json(compact('token'));
    }
}
