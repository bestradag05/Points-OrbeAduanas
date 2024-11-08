<?php

namespace App\Http\Controllers;

use App\Models\AdditionalPoints;
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
            'Asesor',
            'Aduana/Flete',
            'Estado',
            'Acciones'
        ];
        
        

        return view("insurances/list-insurance", compact("insurances","heads"));
    }


    public function getAdditionalPending(){

        $additionals = AdditionalPoints::with('additional')->where('state', 'Pendiente')->get();

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
        
        

        return view("additional_points/pending-list-additional", compact("additionals","heads"));
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
