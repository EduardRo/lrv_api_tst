<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
 


class AuthController extends Controller
{
    //registration

    public function register(Request $request){
       //check some validations
       $validations = Validator::make($request->all(), [
        'name'=>'required|string', 
        'email'=>'required|email|unique:users',
        'password'=>'required',
    
    ]);
    if($validations->fails()){
        $errors = $validations->errors();
        return response()->json([
            'error'=>$errors,
            'status'=>401
            	
        ]);
    }

    if($validations->passes()){
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        
        ]);

        //Create token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'=>200,
            'token'=>$token,
            'user'=>$user,
        
        ]);
    

    }

    }


    // login

    public function login (Request $request){
        if(!Auth::attempt([
            'email' => $request->email, 
            'password' => $request->password
            ])){
            return response()->json([
                'status'=>401,
                'msg'=>'User not found',

            ]);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status'=>200,
            'token'=>$token,
            
        
        ])->cookie('jwt',$token);
    }
}
