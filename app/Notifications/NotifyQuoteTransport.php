<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyQuoteTransport extends Notification
{
    use Queueable;


    protected $quoteTransport;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($quoteTransport, $message)
    {
        $this->quoteTransport = $quoteTransport;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $commercialQuote = $this->quoteTransport->commercial_quote;
        $lcl_fcl = $commercialQuote->lcl_fcl;
        $pickup = $this->quoteTransport->pick_up ? $this->quoteTransport->pick_up : $this->quoteTransport->pickupWarehouse->name_businessname;
        $delivery = $this->quoteTransport->delivery ? $this->quoteTransport->delivery : $this->quoteTransport->deliveryWarehouse->name_businessname;
        $personalName = $commercialQuote->personal->names . ' ' . $commercialQuote->personal->last_name;

        $subjet = 'Cotización Transporte'. ' // '. $lcl_fcl. ' // ' . $pickup . ' - ' . $delivery . ' // ' . $personalName;
        $subjet = mb_strtoupper($subjet, 'UTF-8');

        return (new MailMessage)
            ->subject(strtoupper($subjet)) // Asunto del correo
            ->greeting('Hola ' . $notifiable->personal->names . ' ' . $notifiable->personal->last_name) // Saludo
            ->line($this->message) // Mensaje que se pasa a la notificación
            ->action('Ver cotización', route('quote.transport.show', $this->quoteTransport->id)) // Enlace al detalle de la cotización
            ->line('Gracias por utilizar nuestro sistema de cotizaciones.'); // Mensaje final
    }


    public function toDatabase(object $notifiable): array
    {
        return [
            'quote_transport_id' => $this->quoteTransport->id,
            'message' => $this->message,
            'route' => route('quote.transport.show', $this->quoteTransport->id),
            'oring_user' => auth()->user()->id,
            'type' => 'transport'
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
