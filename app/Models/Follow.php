<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    #user is being followed
    public function userDoingTheFollowing(){
        return $this->belongsTo(User::class,'user_id');
    }

    #user is following another user
    public function userBeingFollowed(){
        return $this->belongsTo(User::class,'followed_user');
    }
    
}
