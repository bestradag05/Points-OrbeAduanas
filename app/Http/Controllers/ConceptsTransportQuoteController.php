<?php

namespace App\Http\Controllers;

use App\Models\QuoteTransport;
use App\Models\ConceptsTransportQuote;
use Illuminate\Http\Request;

class QuoteTransportController extends Controller {
    // Método para almacenar la cotización de transporte
    public function store(Request $request) {
        // Validación de datos
        $validated = $request->validate([
            'nro_quote_commercial' => 'required|string',
            'concepts' => 'required|array',
            'concepts.*.id' => 'required|exists:concepts,id',
            'concepts.*.price' => 'required|numeric',
        ]);

        // Crear la cotización de transporte
        $quoteTransport = QuoteTransport::create([
            'nro_quote_commercial' => $request->nro_quote_commercial,
            // ... otros campos del formulario
        ]);

        // Adjuntar conceptos a la cotización con sus valores
        foreach ($request->concepts as $concept) {
            $netAmount = $concept['price'];
            $igv = $netAmount * 0.18; // 18% de IGV
            $total = $netAmount + $igv;

            ConceptsTransportQuote::create([
                'quote_transport_id' => $quoteTransport->id,
                'id_concepts' => $concept['id'],
                'value_concept' => $concept['price'],
                'net_amount' => $netAmount,
                'igv' => $igv,
                'total' => $total,
            ]);
        }

        return redirect()->back()->with('success', 'Cotización guardada correctamente.');
    }
}
