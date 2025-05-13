<?php

namespace App\Jobs;

use App\Mail\NewPostEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNewPostEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels, Queueable;
    public $incoming;

    /**
     * Create a new job instance.
     */
    public function __construct($incoming)
    {
        $this->incoming = $incoming;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->incoming['sendTo'])->send(new NewPostEmail(['name' => $this->incoming['name'], 'title' => $this->incoming['title']]));
    }
}
