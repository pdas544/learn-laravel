<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Undocumented function
     *
     * @param [type] $userId
     * @return void
     */
    public function createFollow(User $user){
        // you cannot follow yourself
        if($user->id == auth()->user()->id){
            return back()->with('error', 'You cannot follow yourself');
        }

        

        //you cannot follow someone who is already being followed by you
        $existCheck = Follow::where([['user_id','=',auth()->user()->id],['followed_user','=',$user->id]])->count();

        if($existCheck){
            return back()->with('error', 'You are already following this user');
        }

        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followed_user = $user->id;
        $newFollow->save();

        return back()->with('success', 'You are now following this user');
    }

    public function removeFollow(User $user){
        Follow::where([['user_id','=',auth()->user()->id],['followed_user','=',$user->id]])->delete();

        return back()->with('success', 'You have unfollowed this user');
    }
}
