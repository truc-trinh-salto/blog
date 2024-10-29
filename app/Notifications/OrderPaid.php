<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Notifiable;
use App\Models\Order;
use App\Notifications\Messages\VoiceMessage;
use App\Notifications\VoiceChannel;


class OrderPaid extends Notification
{
    use Queueable;
    use Notifiable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database',VoiceChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // return (new MailMessage)->markdown('emails.orders.paid');
        return (new MailMessage)
                    ->subject(__('message._NOTIFYPAID'))
                    ->greeting('Hello')
                    ->line('Your order with '.__('message._ORDERID') .' '.$this->order->id.' has been paid')
                    ->action(__('message._DETAIL'), url('/'))
                    ->attach(storage_path('app/public/test.pdf'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->order->toArray();
    }

    public function toVoice(object $notifiable)
    {
        // ...
    }
}
