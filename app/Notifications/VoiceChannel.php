<?php
 
namespace App\Notifications;
 
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class VoiceChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        $message = $notification->toVoice($notifiable);
        Log::info('Notifcation custom Channel');
        // Send notification to the $notifiable instance...
    }
}