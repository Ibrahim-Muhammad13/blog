<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /**
     * Create User
     * @param Request $request
     * @return User
     */


    public function response($user){
        $token = $user->createToken(str()->random(40))->plainTextToken;
        return response()->json([
            'user'=> $user,
            'token'=>$token,
            'token_type'=>'Bearer'
        ]);
    }

    public function register(Request $request){
        $request->validate([
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:4|confirmed'
        ]);

        $user = User::create([
            'name'=>ucwords($request->name),
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);
        return $this->response($user);
    }

    public function login(Request $request){
        $check = $request->validate([
            'email'=>'required|email|exists:users',
            'password'=>'required|min:4'
        ]);

        if(!Auth::attempt($check)){
            return response()->json([
                'message'=>'unothorized'
            ],401);
        };
        return $this->response(Auth::user());
    }


    public function logout(){
     Auth::user()->tokens()->delete();
     return response()->json([
        'message'=>'you have logged out'
     ]);
    }




}
