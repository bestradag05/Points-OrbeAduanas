<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerSupplierDocument;
use App\Models\QuotesSentClient;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class QuotesSentClientService
{


    public function getQuotesSetClient(array $filters = [])
    {
        $query = QuotesSentClient::query();
        $documents = CustomerSupplierDocument::all();


        $personalId = Auth::user()->personal->id;

        if (!Auth::user()->hasRole('Super-Admin')) {
            $query->where('id_personal', $personalId);
        }

        // Aplicar filtros conocidos
        if (!empty($filters['state'])) {
            $query->where('state', $filters['state']);
        }

        // Puedes seguir agregando más filtros condicionales aquí...

        $quotesSentClient = $query->with('commercialQuote.consolidatedCargos')->get();

        return [
            'quotesSentClient' => $quotesSentClient,
            'documents' => $documents
        ];
    }
}
