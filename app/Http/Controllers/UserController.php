<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{
    public function showAvatar()
    {
        return view('avatar-form');
    }

    public function storeAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]); // Validate the uploaded file

        $user = auth()->user();

        $fileName = $user->id . '-' . uniqid() . '.jpg';

        //using external library: intervention/image
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('avatar'));
        $imageData = $image->cover(128, 128)->toJpeg();
        Storage::disk('public')->put('avatars/' . $fileName, $imageData);

        $oldAvatar = $user->avatar;

        $user->avatar = $fileName;
        $user->save();

        // Delete old avatar if it exists
        if($oldAvatar != "/fallback-avatar.jpg"){
            Storage::disk('public')->delete(str_replace("/storage/","",$oldAvatar)); 
        }

        return back()->with('success', 'Avatar uploaded successfully');
       
    }

    private function getShareData($user) {
        $currentlyFollowing=0;

        if(auth()->check()){
            $currentlyFollowing = Follow::where([['user_id','=',auth()->user()->id],['followed_user','=',$user->id]])->count();
        }

        View::Share('shareData', ['currentlyFollowing'=>$currentlyFollowing,'avatar'=> $user->avatar,'username' => $user->username, 'postCount' => $user->posts()->count()]);
    }

    public function showProfile(User $user){
    
        return view('profile-posts', ['posts' => $user->posts()->latest()->get()]);
    }


    public function profileFollowers(User $user){
        

        return view('profile-posts', ['currentlyFollowing'=>$currentlyFollowing,'avatar'=> $user->avatar,'username' => $user->username, 'posts' => $user->posts()->latest()->get(), 'postCount' => $user->posts()->count()]);
    }

    public function profileFollowing(User $user){
        $currentlyFollowing=0;

        if(auth()->check()){
            $currentlyFollowing = Follow::where([['user_id','=',auth()->user()->id],['followed_user','=',$user->id]])->count();
        }

        return view('profile-posts', ['currentlyFollowing'=>$currentlyFollowing,'avatar'=> $user->avatar,'username' => $user->username, 'posts' => $user->posts()->latest()->get(), 'postCount' => $user->posts()->count()]);
    }
    /**
     *
     * @param Request $request
     */
    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'You are now logged out');
    }
    public function showCorrectHomePage()
    {
        if (auth()->check()) {
            return view('homepage-feed');
        } else {
            return view('home');
        }
    }
    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'min:3', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'confirmed'],
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        auth()->login($user);
        return redirect('/')->with('success', 'Thank you for registering.');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required',
        ]);

        if (auth()->attempt(['username' => $data['loginusername'], 'password' => $data['loginpassword']])) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'You are now logged in');
        } else {
            return redirect('/')->with('error', 'Invalid Credentials');
        }
    }
}
