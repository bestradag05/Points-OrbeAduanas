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

        // 1) Subtotal neto en S/.
        $subtotal      = array_sum($data['price_concept']);
        // 2) IGV al 18%
        $igv           = round($subtotal * 0.18, 2);
        // 3) Total en S/. (subtotal + igv)
        $totalSol      = round($subtotal + $igv, 2);
        // 4) Total en US$
        $totalUsd      = round($totalSol / $data['exchange_rate'], 2);
        // 5) Total + Utilidad en US$
        $totalAnswer   = round($totalUsd + $data['value_utility'], 2);

        // Validación de utilidad mínima
        $minUtility = $quote->type_cargo === 'FCL' ? 60 : 45;
        if ($data['value_utility'] < $minUtility) {
            return back()->withErrors([
                'value_utility' => 'La utilidad mínima para ' . $quote->type_cargo . ' es de $' . $minUtility,
            ])->withInput();
        }

        // Crear respuesta
        $resp = ResponseTransportQuote::create([
            'quote_transport_id'    => $quote->id,
            'provider_id'           => $data['provider_id'],
            'provider_cost'         => $subtotal,
            'exchange_rate'         => $data['exchange_rate'],
            'igv'                   => $igv,
            'total'                 => $totalSol,
            'value_utility'         => $data['value_utility'],
            'total_usd'             => $totalUsd,
            'total_prices_usd'      => $totalAnswer,
            'status'                => 'Enviada',
        ]);

        // Guardar cada concepto neto
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
            'provider_id'             => 'required|exists:suppliers,id',
            'provider_cost'           => 'required|numeric|min:0',
            'commission'              => 'required|numeric|min:0',
            'exchange_rate'           => 'required|numeric|min:0',
            'igv'                      => 'required|numeric|min:0',
            'total'                   => 'required|numeric|min:0',
            'value_utility'           => 'required|numeric|min:0',
            'total_usd'               => 'required|numeric|min:0',
            'total_prices_usd'         => 'required|numeric|min:0',
            'status'                  => 'required|in:Enviada,Aceptada,Rechazada'
        ], [
            'provider_id.required'           => 'Seleccione un proveedor transportista',
            'provider_cost.min'              => 'El costo no puede ser negativo',
            'commission.min'                 => 'La comisión no puede ser negativa',
            'exchange_rate.min'              => 'El tipo de cambio no puede ser negativo',
            'igv.min'                        => 'El IGV no puede ser negativo',
            'total.min'                      => 'El total no puede ser negativo',
            'value_utility.min'              => 'La utilidad no puede ser negativa',
            'total_usd.min'                  => 'El total en dólares no puede ser negativo',
            'total_prices_usd.min'      => 'La suma total no puede ser negativa',
        ]);
    }
}
