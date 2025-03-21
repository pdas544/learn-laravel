<?php

namespace App\Livewire;

use App\Events\ChatMessage;
use Livewire\Component;

class Chat extends Component
{
    public $textvalue='';
    public $chatLog = array();

    public function getListeners(){
        return [
            'echo-private:chatchannel,ChatMessage' => 'newMessage'
        ];
    }

    public function newMessage($message){
        array_push($this->chatLog, $message['chat']);
    }

    public function send(){
        //check if the user is logged in 
        if(!auth()->check()){
            abort(403, 'Unauthorized Access.');
        }

        //check if the text is not empty
        
        if(trim(strip_tags($this->textvalue)) == ''){
           return;
        }

         //add the text to the chatlogs array
         array_push($this->chatLog, ['selfmesssage'=>true,'username' => auth()->user()->name, 'textvalue' => strip_tags($this->textvalue),'avatar' => auth()->user()->avatar]);
         broadcast(new ChatMessage(['selfmessage' => false, 'username' => auth()->user()->username, 'textvalue' => strip_tags($this->textvalue), 'avatar' => auth()->user()->avatar]))->toOthers();
         //reset the text value
         $this->textvalue = '';
    }
    public function render()
    {
        return view('livewire.chat');
    }
}
