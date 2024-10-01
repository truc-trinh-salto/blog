<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


//Artisan console description
Artisan::command('mail:send {user_id}', callback: function (string $user_id) {
    $user = User::find($user_id);
    if($user){
        $name = $user->fullname;
        $this->info("Sending email to: {$name}!");
        return 0;
    } else {
        return 1;
    }
})->purpose('Send a marketing email to a user');
