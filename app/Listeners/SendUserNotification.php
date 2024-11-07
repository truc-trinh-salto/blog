<?php

namespace App\Listeners;

use App\Events\MessageNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendUserNotification implements ShouldQueue, ShouldDispatchAfterCommit
{
    use InteractsWithQueue;
    public $tries = 5;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MessageNotification $event): void
    {
        $user = $event->user;

        Log::info("Listener dispatch login of user: ". $user->fullname);
    }

    public function shouldQueue(MessageNotification $event): bool
    {
        return $event->user->phone_number == "0934541496";
    }

    public function failed(MessageNotification $event, Throwable $throwable){
        Log::info("Failed to dispatching Login Event of user". $event->user->fullname);
    }
}
