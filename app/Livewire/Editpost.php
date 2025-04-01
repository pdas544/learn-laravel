<?php

namespace App\Livewire;

use Livewire\Component;

class Editpost extends Component
{
    public $post;
    public $title;
    public $body;

    public function mount(){
        $this->title = $this->post->title;
        $this->body = $this->post->body;
    }

    public function save(){
        $data = $this->validate([
            'title'=>'required',
            'body'=>'required'
        ]);

        $post['title'] = strip_tags($data['title']);
        $post['body'] = strip_tags($data['body']);

        $this->authorize('update', $this->post);

        $this->post->update($data);

        session()->flash('success', 'Post updated successfully.');
        return $this->redirect("/post/{$this->post->id}/edit",navigate:true);
    }
    public function render()
    {
        return view('livewire.editpost');
    }
}
