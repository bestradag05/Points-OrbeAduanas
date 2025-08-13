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

    public function store(Request $request)
    {
        // 1) Validación
        $data = $this->validateForm($request, null);

        $quoteId = $request->input('quote_id');

        $quote = QuoteTransport::findOrFail($quoteId);

        $includeIgv = ! empty($data['includeIgv']);
        
        // 2) Creamos la respuesta con totales a 0
        $resp = ResponseTransportQuote::create([
            'quote_transport_id'  => $quote->id,
            'provider_id'         => $data['provider_id'],
            'provider_cost'       => 0,
            'exchange_rate'       => $data['exchange_rate'],
            'value_utility'       => 0,
            'igv'           => 0,
            'total_sol'     => 0,
            'total_usd'           => 0,
            'total_prices_usd'    => 0,
            'status'              => 'Enviada',
        ]);

        // 3) Acumuladores
        $sumNet       = 0;
        $sumUtil      = 0;
        $sumIgv   = 0;
        $sumSol   = 0;
        $sumTotalUsd  = 0;
        $sumSalePrice = 0;

        // 4) Recorremos cada concepto recibido
        foreach ($data['conceptTransport'] as $conceptId => $vals) {
            $net       = round($vals['price'], 2);
            $util      = round($vals['utility'], 2);
            $totalUsd  = round($vals['totalusd'], 2);
            $salePrice = round($vals['saleprice'], 2);

            // sólo calculamos IGV si el usuario lo indicó
            $igv = $includeIgv
                ? round($net * 0.18, 2)
                : null;

            // total en soles: net + igv (o solo net si no hay IGV)
            $sol = $includeIgv
                ? round($net + $igv, 2)
                : $net;

            // Acumula en los totales globales
            $sumNet       += $net;
            $sumUtil      += $util;
            $sumIgv  += $igv;
            $sumSol  += $sol;
            $sumTotalUsd  += $totalUsd;
            $sumSalePrice += $salePrice;

            // 5) Guarda detalle por concepto
            $resp->conceptResponseTransports()->create([
                'concepts_id'    => $conceptId,
                'net_amount'     => $net,
                'igv'            => $igv,
                'total_sol'   => $sol,
                'total_usd'      => $totalUsd,
                'value_utility'  => $util,
                'sale_price'     => $salePrice,
            ]);
        }

        // 6) Actualiza los totales de la cabecera
        $resp->update([
            'provider_cost'    => $sumNet,
            'igv'             => $sumIgv,
            'total_sol'       => $sumSol,
            'value_utility'    => $sumUtil,
            'total_usd'        => $sumTotalUsd,
            'total_prices_usd' => $sumSalePrice,
        ]);

        // 7) Redirección de vuelta
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

    private function validateForm(Request $request, $id)
    {
        return $request->validate([
            'provider_id'           => 'required|exists:suppliers,id',
            'exchange_rate'         => 'required|numeric|min:0',
            'conceptTransport'               => 'required|array|min:1',
            'conceptTransport.*.price'       => 'required|numeric|min:0',
            'conceptTransport.*.utility'     => 'required|numeric|min:0',
            'conceptTransport.*.totalusd'    => 'required|numeric|min:0',
            'conceptTransport.*.saleprice'   => 'required|numeric|min:0',
            'includeIgv' => 'sometimes|boolean',
        ], [
            // Mensajes cabecera
            'provider_id.required'       => 'Seleccione un proveedor transportista.',
            'provider_id.exists'         => 'El proveedor seleccionado no es válido.',
            'exchange_rate.required'     => 'Ingrese el tipo de cambio.',
            'exchange_rate.numeric'      => 'El tipo de cambio debe ser un número.',
            'exchange_rate.min'          => 'El tipo de cambio no puede ser negativo.',
            // Mensajes conceptos
            'conceptTransport.required'           => 'Debe cotizar al menos un concepto.',
            'conceptTransport.*.price.required'   => 'Complete el valor del concepto en soles.',
            'conceptTransport.*.price.numeric'    => 'El valor del concepto debe ser numérico.',
            'conceptTransport.*.price.min'        => 'El valor del concepto no puede ser negativo.',
            'conceptTransport.*.utility.required' => 'Complete la utilidad en dólares para el concepto.',
            'conceptTransport.*.utility.numeric'  => 'La utilidad debe ser numérica.',
            'conceptTransport.*.utility.min'      => 'La utilidad no puede ser negativa.',
            'conceptTransport.*.totalusd.required' => 'El total en USD (sin utilidad) es obligatorio.',
            'conceptTransport.*.totalusd.numeric' => 'El total en USD debe ser numérico.',
            'conceptTransport.*.totalusd.min'     => 'El total en USD no puede ser negativo.',
            'conceptTransport.*.saleprice.required' => 'El costo de venta (USD) es obligatorio.',
            'conceptTransport.*.saleprice.numeric' => 'El costo de venta debe ser numérico.',
            'conceptTransport.*.saleprice.min'     => 'El costo de venta no puede ser negativo.',
        ]);
    }
}
