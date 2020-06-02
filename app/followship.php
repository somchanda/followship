<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class followship extends Model
{
    public function user1(){
        return $this->belongsTo(User::class, 'user1_id','id');
    }
    public function user2(){
        return $this->belongsTo(User::class, 'user2_id', 'id');
    }
}
