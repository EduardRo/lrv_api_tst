<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function register(Request $request){
       //check some validations
       $validations = Validator::make($request->all(), [
        'name'=>'required|string', 
        'email'=>'required|email|unique:users|max:155',
        'password'=>'required|min:4',
    
    ]);
    if($validations->fails()){
        $errors = $validations->errors;
        return response()->json([
            'error'=>$errors,
            'status'=>401]);
    }

    }
}
