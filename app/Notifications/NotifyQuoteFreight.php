<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyQuoteFreight extends Notification
{
    use Queueable;

    protected $quoteFreight;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($quoteFreight, $message)
    {
        $this->quoteFreight = $quoteFreight;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        /* return ['mail']; */
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    /* public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    } */

    public function toDatabase(object $notifiable): array
    {
        return [
            'quote_freight_id' => $this->quoteFreight->id,
            'message' => $this->message,
            'route' => route('quote.freight.show', $this->quoteFreight->id),
            'oring_user' => auth()->user()->id,
            'type' => 'freight'
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
