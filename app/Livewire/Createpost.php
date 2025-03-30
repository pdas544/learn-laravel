<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class Createpost extends Component
{
    public $title;
    public $body;

    public function create(){

        if(!auth()->check()){
            abort(403,'Unauthorized');
        }

        $data = $this->validate([
            'title'=>'required',
            'body'=>'required'
        ]);

        //sanitize user input

        $data['title'] = strip_tags($data['title']);
        $data['body'] = strip_tags($data['body']);
        $data['user_id'] = auth()->id();

        //store post data into the database
        $post = Post::create($data);

        session()->flash('success','New post created successfully');

        return $this->redirect("/post/{$post->id}",navigate:true);

       
    }
    public function render()
    {
        return view('livewire.createpost');
    }
}
