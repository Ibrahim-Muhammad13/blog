<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    
    /**
     * Create User
     * @param Request $request
     * @return User
     */

     public function createUser(Request $request){
        $validetor = Validator::make($request->all(),[
            
            'name'=>'required',
            'email'=>'required|email|unique:user',
            'password'=>'required'
        ]);
        if($validetor->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'validation errors',
                'errors'=>$validetor->errors()
            ],401);
         }

         $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password
         ]);

         return response()->json([
            'status'=>true,
            'message'=>'user created sucessfully',
            'token'=>$user->createToken('API TOKEN')->planTextToken
        ],200);

     }

    

}
