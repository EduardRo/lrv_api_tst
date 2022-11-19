<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class TestController extends Controller
{
    //
    public function register(Request $request){
        $validators = Validator::make($request->all(),[
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:4'


        ]);

        if($validators->passes()){
            $user = User::create([
                'name'=>$request->name,

            ]);
            $token = $user->createToken('auth_token')->plainTextToken;
            
            return response()->json(['status'=>200, 'token'=>$token,]);
        }
    }
}

class Test02 extends Controller {

public function register(Request request){
    $validators = Validator::make($request->all(),['name'=>'required|string',
    'email'=>'required|unique:users']);
}

}
