<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
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
            $data = new User();
            $data->name = $request->name;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->save();
            Session::flash("reg_success", "Please login to continue");
            return response()->json(['success'=>'Account created successfully', 'redirect_link' => route('home')]);
        }
    }

    public function loginPost(Request $request){
        $rules = [
            'username'=>'required|string|max:120',
            'password'=>'required|string|max:120|min:6',
        ];
        $messages = [
            'username.required'=>'Username field is required',
            'username.string'=>'Username field is invalid',
            'username.max'=>'Username field is too long',

            'password.required'=>'Password field is required',
            'password.string'=>'Password field is invalid',
            'password.max'=>'Password field is too long',
            'password.min'=>'Please enter at least 6 characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()],422);
        }else{
            $userdata = [
              'username' => $request->username,
              'password' => $request->password
            ];

             if(Auth::attempt($userdata)) {
                 return response()->json(['success'=>'Account created successfully', 'redirect_link' => route('test')]);
             }else{
                 return response()->json(['fail'=>'Invalid Username or password']);
             }

        }
    }
}
