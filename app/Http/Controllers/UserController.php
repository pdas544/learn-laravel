<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{
    /**
     * loginApi
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function loginApi(Request $request){
        $incomingData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (auth()->attempt($incomingData)) {
           $user = User::where('username', $incomingData['username'])->first();
           $token = $user->createToken('API Token')->plainTextToken;
            return $token;
        }
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

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

    private function getSharedData($user) {
        $currentlyFollowing=0;

        if(auth()->check()){
            $currentlyFollowing = Follow::where([['user_id','=',auth()->user()->id],['followed_user','=',$user->id]])->count();
        }

        View::Share('sharedData', ['currentlyFollowing'=>$currentlyFollowing,'avatar'=> $user->avatar,'username' => $user->username, 'postCount' => $user->posts()->count(), 'followerCount' => $user->followers()->count(),'followingCount' => $user->followingTheseUsers()->count()]);
    }
    
    public function showProfile(User $user){
    
        $this->getSharedData($user);
        return view('profile-posts', ['posts' => $user->posts()->latest()->get()]);
    }


    public function profileFollowers(User $user){
        
        $this->getSharedData($user);
        // return $user->followers()->latest()->get();
        return view('profile-followers', ['followers'=>$user->followers()->latest()->get()]);
    }

    public function profileFollowing(User $user){
        $this->getSharedData($user);
        return view('profile-following', ['following' => $user->followingTheseUsers()->latest()->get()]);
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
            return view('homepage-feed',['posts'=>auth()->user()->feedPosts()->latest()->paginate(4)]);
        } else {
            $postCount = Cache::remember('postCount',20,function(){
                
                return Post::count();
            });
            
            return view('home',['postCount'=>$postCount]);
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
