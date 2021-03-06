<?php

namespace App\Http\Controllers;

use App\followship;
use App\notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    function redirect(){
        if(Auth::user()){
            $followers = followship::where('user1_id', '!=', Auth::user()->id)->where('user2_id', Auth::user()->id)->get();
//            $followers = followship::where('user1_id', '!=', Auth::user()->id)->get();
            $following = followship::where('user1_id', Auth::user()->id)->get();
            $notification = notification::where('user_id',Auth::user()->id)->get();
            $user = User::get();
            return view('loggedin.index', compact('followers','following','notification','user'));
        }
        return view('index');
    }

    public function register(){
        return view('home.register');
    }

    public function search(Request $request){
        $term = $request->term;
        $data = User::where('name','LIKE','%'.$term.'%')->get();
        return response()->view('home.partials.people-search', compact('data', 'term'));
    }

    public function userAction(Request $request){
        if($request->action == 'unfollow'){
            if(followship::where('user1_id',$request->user_id)->where('user2_id',Auth::user()->id)->exists()){
                $data = followship::where('user1_id',$request->user_id)->where('user2_id',Auth::user()->id);
                $data->delete();
                $followers = followship::where('user1_id', '!=', Auth::user()->id)->where('user2_id', Auth::user()->id)->get();
                return response()->view('home.partials.follower-action',compact('followers'));
            }else{
                return response()->json(['data' => 'Cannot process data']);
            }
        }elseif($request->action == 'unfollowing'){
            if(followship::where('user2_id',$request->user_id)->where('user1_id',Auth::user()->id)->exists()) {
                $data = followship::where('user2_id', $request->user_id)->where('user1_id', Auth::user()->id);
                $data->delete();
                $following = followship::where('user1_id', Auth::user()->id)->get();
                return response()->view('home.partials.following-action', compact('following'));
            }else{
                return response()->json(['data' => 'Cannot process data']);
            }
        }elseif($request->action == 'reload-people'){
            $user = User::get();
            return response()->view('home.partials.people-reload',compact('user'));
        }elseif($request->action == 'follow'){
            $notify = new notification();
            $notify->user_id = $request->user_id;
            $notify->content = 'You have a new notification';
            $notify->title = 'You have a new notification';
            $notify->save();

            $following = new followship();
            $following->user1_id = Auth::user()->id;
            $following->user2_id = $request->user_id;
            $following->save();
            $following = followship::where('user1_id', Auth::user()->id)->get();
            return response()->view('home.partials.following-action',compact('following'));

        }
    }

    public function checkNotification(Request $request){
        $data = notification::where('user_id',Auth::user()->id)->get();
        return response()->json(['data' => $data->count()]);
    }

    public function reloadFollower(){
        $followers = followship::where('user1_id', '!=', Auth::user()->id)->where('user2_id', Auth::user()->id)->get();
        return response()->view('home.partials.follower-action',compact('followers'));
    }

    public function reloadDashboard(){
        $followers = followship::where('user1_id', '!=', Auth::user()->id)->where('user2_id', Auth::user()->id)->get();
        $following = followship::where('user1_id', Auth::user()->id)->get();
        $notification = notification::where('user_id',Auth::user()->id)->get();
        return response()->view('home.partials.dashboard-action', compact('followers','following','notification'));
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
                 return response()->json(['success'=>'Account created successfully', 'redirect_link' => route('home')]);
             }else{
                 return response()->json(['fail'=>'Invalid Username or password']);
             }
        }
    }
}
