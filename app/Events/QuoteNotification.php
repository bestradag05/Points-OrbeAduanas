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

class QuoteNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $message;

    // Constructor para pasar datos
    public function __construct($message)
    {
        $this->message = $message;
    }

    // Canal por el cual se emitirá el mensaje
    public function broadcastOn()
    {
        return new PrivateChannel('quote');
    }

    // Datos que se enviarán al frontend
    public function broadcastWith()
    {
        return [
            'message' => $this->message,
        ];
    }
}
