<?php

namespace App\Http\Controllers;

use App\Models\ResponseTransportQuote;
use App\Models\Supplier;
use App\Models\ConceptsTransportQuote;
use App\Models\Concepts;
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
        $this->validateForm($request, null);
        
        $response = ResponseTransportQuote::create([
            'nro_response'   => ResponseTransportQuote::generateNroResponse(),
            'provider_id'    => $request->provider_id,
            'provider_cost'  => $request->provider_cost,
            'commission'     => $request->commission,
            'total'          => $request->provider_cost + $request->commission,
            'status'         => 'Enviada'
        ]);
        
        // Asumimos que el tipo de envío se envía en el request o se conoce de otro modo
        $typeShipmentId = $request->type_shipment_id; // Asegúrate de enviarlo
        
        $transportConcept = Concepts::where('name', 'TRANSPORTE')
            ->where('id_type_shipment', $typeShipmentId)
            ->first();
        
        if ($transportConcept) {
            ConceptsTransportQuote::create([
                'quote_id'     => $request->quote_id, // si se está usando
                'concept_id'   => $transportConcept->id,
                'value_concept'=> $request->provider_cost, // o el valor que desees asociar
            ]);
        }

        return redirect()->route('response-transport-quotes.index')->with('success', 'ok');
    }

    public function edit(string $id)
    {
        $suppliers = Supplier::where('supplier_type', 'Transportista')->get();
        $quote = ResponseTransportQuote::findOrFail($id);
        return view('response-transport-quotes.edit', compact('quote', 'suppliers'));
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
