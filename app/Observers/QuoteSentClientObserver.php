<?php

namespace App\Observers;

use App\Models\QuotesSentClient;
use Illuminate\Http\Client\Request;

class QuoteSentClientObserver
{
    /**
     * Handle the QuotesSentClient "created" event.
     */
    public function created(QuotesSentClient $quotesSentClient): void
    {
        $quotesSentClient->registerTrace('Creado', "Cotización enviada al cliente generada con el codigo {{$quotesSentClient->nro_quote_commercial}}");
    }

    /**
     * Handle the QuotesSentClient "updated" event.
     */
    public function updated(QuotesSentClient $quotesSentClient): void
    {
        if ($quotesSentClient->isDirty('status')) {
            // Aquí obtenemos la justificación directamente del modelo
            $justification = $quotesSentClient->justification ?? 'No se proporcionó justificación';
            $quotesSentClient->registerTrace($quotesSentClient->status, $justification);
        }
    }

    /**
     * Handle the QuotesSentClient "deleted" event.
     */
    public function deleted(QuotesSentClient $quotesSentClient): void
    {
        //
    }

    /**
     * Handle the QuotesSentClient "restored" event.
     */
    public function restored(QuotesSentClient $quotesSentClient): void
    {
        //
    }

    /**
     * Handle the QuotesSentClient "force deleted" event.
     */
    public function forceDeleted(QuotesSentClient $quotesSentClient): void
    {
        //
    }
}
