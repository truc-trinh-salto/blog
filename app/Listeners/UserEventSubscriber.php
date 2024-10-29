<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\MessageNotification;
use App\Events\LogoutEvent;
use GuzzleHttp\Psr7\Message;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Client\Events\ConnectionFailed;
use Illuminate\Cache\Events\CacheHit;


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

    public function handleUserSendEmail(MessageSending $event){
        Log::info("Listener Email Sending dispatch of user: ");
    }

    public function handleRequestSending(RequestSending $event){
        Log::info("Listener Request Sending dispatch of user: ");

    }

    public function handleConnectionFailed(ConnectionFailed $event){
        Log::info("Listener Connection Failed dispatch of user: ");

    }

    public function handleCacheHit(CacheHit $event){
        Log::info("Cache hit dispatch of user: ");

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

        $events->listen(
            MessageSending::class,
            [UserEventSubscriber::class, 'handleUserSendEmail']
        );


        //Cache events when get key in Cache
        $events->listen(
            CacheHit::class,
            [UserEventSubscriber::class, 'handleCacheHit']
        );

        // return [
        //     Login::class => 'handleUserLogin',
        //     Logout::class => 'handleUserLogout',
        // ];
    }
}
