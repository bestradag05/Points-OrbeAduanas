<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Queue\SerializesModels;

class QuoteNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

     public $quote;

    /**
     * Create a new notification instance.
     */
    public function __construct($quote)
    {
        $this->quote = $quote;
    }

    public function via($notifiable)
    {
        return ['broadcast'];  // El canal que deseas usar
    }



    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'quote_id' => $this->quote->id,  // Aquí accedes a la propiedad de la cotización
            'message' => 'Nueva cotización disponible'
        ]);
    }



}
