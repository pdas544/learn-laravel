<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class Search extends Component
{
    public $searchTerm = '';
    public $searchResults;
    public function render()
    {
        if($this->searchTerm == ''){
            $this->searchResults = array();
        }else{
            $posts = Post::search($this->searchTerm)->get();
            $this->searchResults = $posts;
        }
        return view('livewire.search');
    }
}
