<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Follow;
use Livewire\Component;

class Addfollow extends Component
{
    public $username;
    public function save(){
        if(!auth()->check()){
            abort(403,'Unauthorized action.');
        }

        $user= User::where('username', $this->username)->first(); 

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

        session()->flash('success', 'You are now following this user');
        return $this->redirect("/profile/{$this->username}",navigate:true);

    }
    public function render()
    {
        return view('livewire.addfollow');
    }
}
