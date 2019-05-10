<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use JWTAuth;
use JWTAuthException;
use App\User;


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
                'user' => $data,
                'point' => 0
            ],
        ]);
    }

    public function registerDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gender' => 'required',
            'date_birth' => 'required',
            'no_hp' => 'required',
            'no_wa' => 'required'
        ], [
            'gender.required' => 'Kelamin wajib di isi',
            'no_hp.required' => 'No HP wajib di isi'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'data' => null,
                'message' => $validator
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
                'user' => $data,
                'point' => 0
            ],
        ]);
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
                'user' => $user,
                'point' => $point
            ],
        ]);
    }

    public function refreshToken(){
        $token = JWTAuth::parseToken()->refresh();
        return response()->json(compact('token'));
    }
}
