<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        //sanitize user input

        $data['title'] = strip_tags($data['title']);
        $data['body'] = strip_tags($data['body']);
        $data['user_id'] = auth()->id();

        //store post data into the database
        $post = Post::create($data);

        //redirect the user to show the newly created post
        return redirect("/post/{$post->id}")->with('success','New post created successfully');
    }

    /**
     * Type Hinting: when an object is passed to a function, we can specify the type of the object, in this case Post.
     * 
    */
    public function showSinglePost(Post $post){
        $post['body'] = Str::markdown($post->body);

        return view('single-post',['post'=>$post]);
    }
}
