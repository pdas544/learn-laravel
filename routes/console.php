<?php

use App\Mail\RecapEmail;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

//schedule an email, use Schedule facade
Schedule::call(function(){
    Mail::to('test@google.com')->send(new RecapEmail());
})->everyMinute();