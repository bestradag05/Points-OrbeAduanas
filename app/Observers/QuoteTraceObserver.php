<?php

namespace App\Observers;

use App\Models\ResponseTransportQuote;
use App\Models\QuoteTrace;
use Illuminate\Support\Facades\Auth;

class QuoteTraceObserver
{
    /**
     * Handle the ResponseTransportQuote "created" event.
     */
    public function created(ResponseTransportQuote $responseTransportQuote): void
    {
        //
    }

    /**
     * Handle the ResponseTransportQuote "updated" event.
     */
    public function updated(ResponseTransportQuote $response): void
    {
        if ($response->isDirty('status') && in_array($response->status, ['confirmada', 'rechazada'])) {
            QuoteTrace::create([
                'quote_id' => $response->quote_transport_id,
                'service_type' => 'transporte',
                'response_id' => $response->id,
                'action' => $response->status,
                'justification' => request()->input('justification') ?? null,
                'user_id' => auth()->id(),
            ]);
        }
    }

    /**
     * Handle the ResponseTransportQuote "deleted" event.
     */
    public function deleted(ResponseTransportQuote $responseTransportQuote): void
    {
        //
    }

    /**
     * Handle the ResponseTransportQuote "restored" event.
     */
    public function restored(ResponseTransportQuote $responseTransportQuote): void
    {
        //
    }

    /**
     * Handle the ResponseTransportQuote "force deleted" event.
     */
    public function forceDeleted(ResponseTransportQuote $responseTransportQuote): void
    {
        //
    }
}
