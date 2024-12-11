<?php

namespace App\Http\Controllers;

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
