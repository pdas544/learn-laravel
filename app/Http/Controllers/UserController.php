<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function showAvatar(){
        return view('avatar-form');
    }

    public function storeAvatar(Request $request){
        $request->validate([
            'avatar'=>'required|image|max:2048'
        ]);  // Validate the uploaded file
        
        $request->file('avatar')->store('avatars','public');
        // return 'uploaded';
    }
    
    public function showProfile(User $user){
        
        return view('profile-posts',['username'=>$user->username,'posts'=>$user->posts()->latest()->get(),'postCount'=>$user->posts()->count()]);
    }
    /**
     * 
     * @param Request $request
    */
    public function logout(){
        auth()->logout();
        return redirect('/')->with('success','You are now logged out');
    }
    public function showCorrectHomePage(){
        if(auth()->check()){
            return view('homepage-feed');
        }else{
            return view('home');
        }
    }
    public function register(Request $request){
        $data = $request->validate([
            'username' => ['required','min:3',Rule::unique('users','username')],
            'email'=>['required','email',Rule::unique('users','email')],
            'password'=>['required','min:5','confirmed']
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        auth()->login($user);
        return redirect('/')->with('success','Thank you for registering.');
    }

    public function login(Request $request){
        $data = $request->validate([
            'loginusername'=>'required',
            'loginpassword'=>'required'
        ]);
        

        if(auth()->attempt(['username'=>$data['loginusername'],'password'=>$data['loginpassword']])){
            $request->session()->regenerate();
            return redirect('/')->with('success','You are now logged in');
        }else{
return redirect('/')->with('error','Invalid Credentials');
        }
    }
    
}
