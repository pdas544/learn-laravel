<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Follow;
use Livewire\Component;

class Removefollow extends Component
{
    public $username;

    public function save(){
        if(!auth()->check()){
            abort(403, 'Unauthorized action.');
        }

        //find the current user
        $user = User::where('username', $this->username)->first();

        Follow::where([['user_id','=',auth()->user()->id],['followed_user','=',$user->id]])->delete();

        session()->flash('success', 'You have unfollowed this user');
        return $this->redirect("/profile/{$this->username}",navigate:true);
    }

    public function render()
    {
        return view('livewire.removefollow');
    }
}
