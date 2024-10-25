<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


//Artisan console description
Artisan::command('mail:send {user_id}', function (string $user_id) {
    $user = User::find($user_id);
    if($user){
        $name = $user->fullname;
        $this->info("Sending email to: {$name}!");
        return 0;
    } else {
        $this->error('Something went wrong!');
        return 1;
    }
})->purpose(
    'Send a marketing email to a user');
