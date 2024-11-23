<?php

namespace App\Http\Controllers;

use App\Models\AdditionalPoints;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdditionalPointsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $additionals = AdditionalPoints::with('additional')->get();

        $heads = [
            '#',
            'N° Operacion',
            'Servicio',
            'Monto',
            'IGV',
            'Total',
            'Puntos',
            'Tipo Punto',
            'Estado',
            'Acciones'
        ];



        return view("additional_points/list-additional", compact("additionals", "heads"));
    }


    public function getAdditionalPendingCustom()
    {

        $additionals = AdditionalPoints::with('additional')
            ->where('state', 'Pendiente')
            ->where('additional_type', 'AD-ADUANA')
            ->get();

        $heads = [
            '#',
            'N° Operacion',
            'Servicio',
            'Monto',
            'IGV',
            'Total',
            'Puntos',
            'Tipo Punto',
            'Estado',
            'Acciones'
        ];



        return view("additional_points/pending-list-additional-custom", compact("additionals", "heads"));
    }


    public function getAdditionalPendingFreight()
    {

        $additionals = AdditionalPoints::with('additional')
            ->where('state', 'Pendiente')
            ->where('additional_type', 'AD-FLETE')
            ->get();

        $heads = [
            '#',
            'N° Operacion',
            'Servicio',
            'Monto',
            'IGV',
            'Total',
            'Puntos',
            'Tipo Punto',
            'Estado',
            'Acciones'
        ];



        return view("additional_points/pending-list-additional-freight", compact("additionals", "heads"));
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
        // Obtenemos el registro que se va editar
        $additional = AdditionalPoints::with('additional')->find($id);

        if ($additional->additional_type === 'AD-FLETE') {
            $additional->update([
                'administrator' => auth()->user()->personal->names,
                'state' => 'Generado'
            ]);


            return redirect()->back();
        }

        return view('additional_points/edit-additional', compact('additional'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateForm($request, $id);

        $insurance = AdditionalPoints::find($id);

        $dateRegisterFormat = Carbon::createFromFormat('d/m/Y', $request['date_register'])->toDateString();
        $request['date_register'] = $dateRegisterFormat;

        $request['state'] = "Generado";

        $insurance->fill($request->all());
        $insurance->save();

        return redirect('additionals');
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
            'bl_to_work' => 'required|string',
            'ruc_to_invoice' => 'required|string',
            'invoice_number' => 'required|string',
            'date_register' => 'required|string',
        ]);
    }

}
