<?php

namespace App\Http\Controllers;

use App\Models\ResponseTransportQuote;
use App\Models\Supplier;
use App\Models\ConceptsQuoteTransport;
use App\Models\QuoteTransport;
use App\Models\Concept;
use Illuminate\Http\Request;

class ResponseTransportQuoteController extends Controller
{
    public function index()
    {
        $quotes = ResponseTransportQuote::with('supplier')->get();

        $heads = [
            '#',
            'Proveedor',
            'Costo Proveedor',
            'Comisión',
            'Total',
            'Estado',
            'Acciones'
        ];

        return view('response-transport-quotes.list', compact('quotes', 'heads'));
    }

    public function create()
    {
        $suppliers = Supplier::where('supplier_type', 'Transportista')->get();
        return view('response-transport-quotes.register', compact('suppliers'));
    }

    public function store(Request $request, $quoteId)
    {
        $data = $request->validate([
            'provider_id'     => 'required|exists:suppliers,id',
            'price_concept.*' => 'required|numeric|min:0',
            'exchange_rate'   => 'required|numeric|min:0.1',
            'value_utility'   => 'required|numeric|min:0',
        ]);

        $quote = QuoteTransport::findOrFail($quoteId);

        $totalSoles = array_sum($data['price_concept']);
        $totalUSD = $totalSoles / $data['exchange_rate'];
        $totalFinalUSD = $totalUSD + $data['value_utility'];

        // Validación: utilidad mínima
        $minUtility = $quote->type_cargo === 'FCL' ? 60 : 45;
        if ($data['value_utility'] < $minUtility) {
            return back()->withErrors([
                'value_utility' => 'La utilidad mínima para ' . $quote->type_cargo . ' es de $' . $minUtility,
            ])->withInput();
        }

        $resp = ResponseTransportQuote::create([
            'quote_transport_id' => $quote->id,
            'provider_id'        => $data['provider_id'],
            'provider_cost'      => $totalSoles,
            'exchange_rate'      => $data['exchange_rate'],
            'value_utility'      => $data['value_utility'],
            'total'              => round($totalFinalUSD, 2),
            'status'             => 'Enviada',
        ]);

        foreach ($data['price_concept'] as $conceptId => $price) {
            $resp->conceptResponseTransports()->create([
                'concepts_id' => $conceptId,
                'net_amount'  => $price,
            ]);
        }

        return redirect()
            ->route('transport.show', $quoteId)
            ->with('success', 'Cotización de transporte registrada.');
    }



    public function update(Request $request, string $id)
    {
        $this->validateForm($request, $id);

        $quote = ResponseTransportQuote::findOrFail($id);
        $quote->update([
            'provider_id' => $request->provider_id,
            'provider_cost' => $request->provider_cost,
            'commission' => $request->commission,
            'total' => $request->provider_cost + $request->commission,
            'status' => $request->status
        ]);

        return redirect()->route('response-transport-quotes.index')->with('edit', 'ok');
    }

    public function destroy(string $id)
    {
        $quote = ResponseTransportQuote::find($id);
        $quote->update(['status' => 'Rechazada']);
        return redirect()->route('response-transport-quotes.index')->with('eliminar', 'ok');
    }

    private function validateForm($request, $id)
    {
        $request->validate([
            'provider_id' => 'required|exists:suppliers,id',
            'provider_cost' => 'required|numeric|min:0',
            'commission' => 'required|numeric|min:0',
            'status' => 'required|in:Enviada,Aceptada,Rechazada'
        ], [
            'provider_id.required' => 'Seleccione un proveedor transportista',
            'provider_cost.min' => 'El costo no puede ser negativo',
            'commission.min' => 'La comisión no puede ser negativa'
        ]);
    }
}
