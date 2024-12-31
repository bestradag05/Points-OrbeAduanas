<?php

namespace App\Http\Controllers;

use App\Models\AdditionalPoints;
use App\Models\Supplier;
use App\Models\Transport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Listar transportes

        $transports = Transport::all();

        $heads = [
            '#',
            'N° Operacion',
            'Asesor',
            'Origen',
            'Destino',
            'Estado',
            'Acciones'
        ];

        return view("transport/list-transport", compact("transports", "heads"));
    }



    public function getTransportPending()
    {

        //Listar aduanas

        $transports = Transport::where('state', 'Pendiente')->get();

        $heads = [
            '#',
            'N° Operacion',
            'Asesor',
            'Origen',
            'Destino',
            'Estado',
            'Acciones'
        ];


        return view("transport/pending-list-transport", compact("transports", "heads"));
    }


    public function getTransportPersonal()
    {
        $personalId = Auth::user()->personal->id;

        // Verificar si el usuario es un Super-Admin
        if (Auth::user()->hasRole('Super-Admin')) {
            // Si es Super-Admin, obtener todos los routing
            $transports = Transport::with('quoteTransports')->get();
        } else {
            // Si no es Super-Admin, solo obtener los clientes que pertenecen al personal del usuario autenticado
            $transports = Transport::whereHas('routing', function ($query) use ($personalId) {
                $query->where('id_personal', $personalId);
            })->with('quoteTransports')->get();
        }

        $heads = [
            '#',
            'N° De transporte',
            'N° Operacion',
            'Origen',
            'Destino',
            'Total de transporte',
            'Fecha de retiro',
            'Estado',
        ];

        return view("transport/list-transport-personal", compact("transports", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $tax_base = $this->parseDouble($request->transport_value) + $this->parseDouble($request->transport_added);
        $igv = $tax_base * 0.18;
        $total = $tax_base * 1.18;

        $transport = Transport::create([

            'origin' => $request->origin,
            'destination' => $request->destination,
            'transport_value' => $this->parseDouble($request->transport_value),
            'added_value' => $this->parseDouble($request->transport_added),
            'tax_base' => $tax_base,
            'igv' => $igv,
            'total' => $total,
            'additional_points' => $request->additional_points,
            'withdrawal_date' =>  $request->withdrawal_date,
            'id_quote_transport' => $request->id_quote_transport,
            'state' => 'Pendiente'

        ]);


        if ($transport->additional_points && $this->parseDouble($transport->additional_points) > 0) {
            $concept = (object) ['name' => 'TRANSPORTE', 'pa' => $transport->additional_points];

            $this->add_aditionals_point($concept, $transport, $transport->tax_base, $transport->igv, $transport->total);
        }
        //Relacionamos los conceptos que tendra este transporte

        foreach (json_decode($request->concepts) as $concept) {

            $ne_amount = $this->parseDouble($concept->value) + $this->parseDouble($concept->added);
            $igv = $ne_amount * 0.18;
            $total = $ne_amount + $igv;

            $transport->concepts()->attach($concept->id, [
                'value_concept' => $concept->value,
                'added_value' => $concept->added,
                'net_amount' => round($ne_amount, 2),
                'igv' => round($igv),
                'total' => round($total),
                'additional_points' => isset($concept->pa)
            ]);

            //Verificamos si tienen puntos adicionales
            if (isset($concept->pa)) {
                $this->add_aditionals_point($concept, $transport, $ne_amount, $igv, $total);
            }
        }


        return redirect('/transport/personal');
    }



    public function add_aditionals_point($concept, $service,  $ne_amount = null, $igv = null, $total = null)
    {


        $additional_point = AdditionalPoints::create([
            'type_of_service' => $concept->name,
            'amount' => ($ne_amount != 0 && $ne_amount != null) ? $ne_amount : $this->parseDouble($concept->value) +  $this->parseDouble($concept->added),
            'igv' => $igv,
            'total' => $total,
            'points' => $concept->pa,
            'id_additional_service' => $service->id,
            'model_additional_service' => $service::class,
            'additional_type' => ($service::class === 'App\Models\Freight') ? 'AD-FLETE' : 'AD-ADUANA',
            'state' => 'Pendiente'
        ]);


        $service->additional_point()->save($additional_point);
    }

    public function parseDouble($num)
    {

        $valorDecimal = (float)str_replace(',', '', $num);

        return $valorDecimal;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $transport = Transport::find($id);
        $suppliers = Supplier::all();

        return view('transport/edit-transport', compact('transport', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateForm($request, $id);

        $transport = Transport::find($id);


        $dateRegisterFormat = Carbon::createFromFormat('d/m/Y', $request['date_register'])->toDateString();
        $request['date_register'] = $dateRegisterFormat;

        $paymentDateFormat = Carbon::createFromFormat('d/m/Y', $request['payment_date'])->toDateString();
        $request['payment_date'] = $paymentDateFormat;

        $request['state'] = "Generado";

        $transport->fill($request->all());
        $transport->save();

        return redirect('transport');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    public function validateForm($request, $id)
    {
        $request->validate([
            'date_register' => 'required|string',
            'invoice_number' => 'required|string|unique:transport,invoice_number,' . $id,
            'nro_orden' => 'required|string|unique:transport,nro_orden,' . $id,
            'nro_dua' => 'required|string|unique:transport,nro_dua,' . $id,
            'nro_dam' => 'string|unique:transport,nro_dam,' . $id,
            'id_supplier' => 'required',
            'payment_state' => 'required|string',
            'payment_date' => 'required|string',
            'weight' => 'required|string'
        ]);
    }
}
