<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\MessageNotification;
use App\Events\LogoutEvent;
use GuzzleHttp\Psr7\Message;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;

class UserEventSubscriber
{
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
    public function handleUserLogin(MessageNotification $event): void
    {
        Log::info("Listener subcriber dispatch login of user: ".$event->user->fullname);
    }

    public function handleUserLogout(LogoutEvent $event): void
    {
        Log::info("Listener subcriber dispatch logout of user: ".$event->user->fullname);
        
    }

    public function subscribe(Dispatcher $events): void
    {
        
        $events->listen(
            MessageNotification::class,
            [UserEventSubscriber::class, 'handleUserLogin']
        );
 
        $events->listen(
            LogoutEvent::class,
            [UserEventSubscriber::class, 'handleUserLogout']
        );

        // return [
        //     Login::class => 'handleUserLogin',
        //     Logout::class => 'handleUserLogout',
        // ];
    }
}
