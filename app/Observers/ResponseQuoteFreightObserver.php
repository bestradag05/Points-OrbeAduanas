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
        $responseFreightQuotes->registerTrace('Actualizado', 'Respuesta de cotizacion de flete actualizada');
    }

    /**
     * Handle the ResponseFreightQuotes "deleted" event.
     */
    public function deleted(ResponseFreightQuotes $responseFreightQuotes): void
    {
       $responseFreightQuotes->registerTrace('Eliminado', 'respuesta de transporte eliminada');
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
