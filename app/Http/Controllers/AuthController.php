<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(){
        return view('home.register');
    }
    public function registerPost(Request $request){
        $rules = [
          'name'=>'required|string|max:120',
          'username'=>'required|string|max:120',
          'password'=>'required|string|max:120|min:6',
          'email'=>'required|email|max:120'
        ];
        $messages = [
            'name.required'=>'Name field is required',
            'name.string'=>'Name field is invalid',
            'name.max'=>'Name field is too long',

            'username.required'=>'Username field is required',
            'username.string'=>'Username field is invalid',
            'username.max'=>'Username field is too long',

            'password.required'=>'Password field is required',
            'password.string'=>'Password field is invalid',
            'password.max'=>'Password field is too long',
            'password.min'=>'Please enter at least 6 characters',

            'email.required'=>'Email field is required',
            'email.string'=>'Email field is invalid',
            'email.max'=>'Email field is too long',
            'email.email'=>'Please enter a valid email address',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()],422);
        }else{
            return 'all good';
        }
    }
}
