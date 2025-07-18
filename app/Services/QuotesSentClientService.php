<?php

namespace App\Services;

use App\Models\QuotesSentClient;
use Illuminate\Support\Facades\Auth;

class QuotesSentClientService
{


    public function getQuotesSetClient(array $filters = [])
    {
        $query = QuotesSentClient::query();

        $personalId = Auth::user()->personal->id;

        if (!Auth::user()->hasRole('Super-Admin')) {
            $query->where('id_personal', $personalId);
        }

        // Aplicar filtros conocidos
        if (!empty($filters['state'])) {
            $query->where('state', $filters['state']);
        }

        // Puedes seguir agregando más filtros condicionales aquí...

        return [
            'quotesSentClient' => $query->get()
        ];
    }
}
