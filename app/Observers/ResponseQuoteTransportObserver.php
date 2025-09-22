<?php

namespace App\Observers;

use App\Models\ResponseTransportQuote;
use Illuminate\Support\Facades\Request;

class ResponseQuoteTransportObserver
{
    public function created(ResponseTransportQuote $response)
    {
        $response->registerTrace('Creado', 'Respuesta de cotización de transporte creada');
    }

    public function updated(ResponseTransportQuote $response)
    {
            $response->registerTrace('Actualizado','Respuesta de cotización de transporte actualizado');
    }

    public function deleted(ResponseTransportQuote $response)
    {
        $response->registerTrace('Eliminado', 'Respuesta de transporte eliminada');
    }

    public function restored(ResponseTransportQuote $response)
    {
        //
    }

    public function forceDeleted(ResponseTransportQuote $response)
    {
        //
    }
}
