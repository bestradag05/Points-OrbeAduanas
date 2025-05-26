<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Notify extends Notification
{
    use Queueable;

    protected $freight;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($freight, $message)
    {
        $this->freight = $freight;
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
            'freight_id' => $this->freight->id,
            'message' => $this->message,
            'route' => route('freight.show', $this->freight->id),
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
