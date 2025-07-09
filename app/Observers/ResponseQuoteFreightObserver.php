<?php

namespace App\Observers;

use App\Models\ResponseFreightQuotes;
use Illuminate\Support\Facades\Request;

class ResponseQuoteFreightObserver
{
    /**
     * Handle the ResponseFreightQuotes "created" event.
     */
    public function created(ResponseFreightQuotes $responseFreightQuotes): void
    {
        //Trace
        $responseFreightQuotes->registerTrace('Creado', 'Respuesta de cotizacion de flete creada');
    }

    /**
     * Handle the ResponseFreightQuotes "updated" event.
     */
    public function updated(ResponseFreightQuotes $responseFreightQuotes): void
    {
        //

        if ($responseFreightQuotes->isDirty('status')) {
            //Verificamos si viene la justificacion por parte del usuario y si no agregamos el mensaje por defecto.
            $justification = Request::input('justification', 'Cambio de estado de la respuesta');
            $responseFreightQuotes->registerTrace($responseFreightQuotes->status, $justification);
        }
    }

    /**
     * Handle the ResponseFreightQuotes "deleted" event.
     */
    public function deleted(ResponseFreightQuotes $responseFreightQuotes): void
    {
       $responseFreightQuotes->registerTrace('deleted', 'respuesta de transporte eliminada');
    }

    /**
     * Handle the ResponseFreightQuotes "restored" event.
     */
    public function restored(ResponseFreightQuotes $responseFreightQuotes): void
    {
        //
    }

    /**
     * Handle the ResponseFreightQuotes "force deleted" event.
     */
    public function forceDeleted(ResponseFreightQuotes $responseFreightQuotes): void
    {
        //
    }
}
