<?php

use Illuminate\Support\Facades\Auth;

function isFollowing($id){
        if(\App\followship::where('user1_id', $id)->where('user2_id', Auth::user()->id)->exists()){
            return 'follower';
        }elseif (\App\followship::where('user2_id', $id)->where('user1_id', Auth::user()->id)->exists()){
            return 'following';
        }else{
            return 'none';
        }
    }
