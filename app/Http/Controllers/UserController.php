<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    public function register(Request $request){
        $data = $request->validate([
            'username' => ['required','min:3',Rule::unique('users','username')],
            'email'=>['required','email',Rule::unique('users','email')],
            'password'=>['required','min:5','confirmed']
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return 'hello from register function';
    }
    
}
