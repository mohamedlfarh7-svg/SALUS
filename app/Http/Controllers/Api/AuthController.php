<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
      
    $data = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6'
    ]);
    $data['password'] = Hash::make($data['password']);
    $user = User::create($data);

    return response()->json([
            'massege' => 'successfully register',
            'user' => $user
    ],201);
    }

     public function login(Request $request){
        
       $request->validate([
           'email' => 'required|email',
           'password' => 'required'
       ]);

       if(!Auth::attempt($request->only('email','password'))){
            return response()->json(['massege' => 'Invalid login'],401);
       }
       $user = User::where('email',$request->email)->first();
       $token = $user->createToken('api-token')->plainTextToken;

       return response()->json([
              'massege' => 'successfull login',
              'user' => $user,
              'token' => $token
       ],201);
     }

     public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
            'massege' => 'successfully logout',
        ],201);
     }
}