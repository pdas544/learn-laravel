<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{


    public function showForm(){
        return view('create-post');
    }

    public function createNewPost(Request $request){
        $data = $request->validate([
            'title'=>'required',
            'body'=>'required'
        ]);

        $data['title'] = strip_tags($data['title']);
        $data['body'] = strip_tags($data['body']);
        $data['user_id'] = auth()->id();

        Post::create($data);

        return 'Stored';
    }
}
