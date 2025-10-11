<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyQuoteFreightResponse extends Notification
{
    use Queueable;

    protected $responseQuoteFreight;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($responseQuoteFreight, $message)
    {
        $this->responseQuoteFreight = $responseQuoteFreight;
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
        $commercialQuote = $this->responseQuoteFreight->quote->commercial_quote;
        $regime = $commercialQuote->regime->description;
        $origin = $commercialQuote->originState->country->name . '  ' . $commercialQuote->originState->name;
        $destination =  $commercialQuote->destinationState->country->name . '  ' . $commercialQuote->destinationState->name;
        $incoterm = $commercialQuote->incoterm->code;
        $personalName = $commercialQuote->personal->names . ' ' . $commercialQuote->personal->last_name;

        $subjet = 'RESPUESTA: Cotización ' . $regime . ' // ' . $origin . ' - ' . $destination . ' // ' . $incoterm . ' // ' . $personalName;
        $subjet = mb_strtoupper($subjet, 'UTF-8');

        return (new MailMessage)
            ->subject(strtoupper($subjet)) // Asunto del correo
            ->greeting('Hola ' . $notifiable->personal->names . ' ' . $notifiable->personal->last_name) // Saludo
            ->line($this->message) // Mensaje que se pasa a la notificación
            ->action('Ver cotización', route('quote.freight.show', $this->responseQuoteFreight->quote->id)) // Enlace al detalle de la cotización
            ->line('Gracias por utilizar nuestro sistema de cotizaciones.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'response_quote_freight_id' => $this->responseQuoteFreight->id,
            'message' => $this->message,
            'route' => route('quote.freight.show', $this->responseQuoteFreight->quote->id),
            'oring_user' => auth()->user()->id,
            'type' => 'freight'
        ];
    }
}
