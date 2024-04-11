<?php

namespace App\Http\Controllers;

use App\Models\Freight;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FreightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $freights = Freight::all();
       

        $heads = [
            '#',
            'N° Operacion',
            'Asesor',
            'Utilidad a Orbe',
            'Estado',
            'Acciones'
        ];
        
        

        return view("freight/list-freight", compact("freights","heads"));
    }


    public function getFreightPending(){

        $freights = Freight::where('state', 'Pendiente')->get()->load('routing.personal');
       

        $heads = [
            '#',
            'N° Operacion',
            'Asesor',
            'Utilidad a Orbe',
            'Estado',
            'Acciones'
        ];
        
        

        return view("freight/pending-list-freight", compact("freights","heads"));
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

         $freight = Freight::find($id);
         $value_freight = 0;

         /* $freight->load('concepts'); */
         
     

         foreach($freight->concepts as $concept){
            $value_freight += $concept->pivot->value_concept;
            
         }

         return view('freight/edit-freight', compact('freight', 'value_freight'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->validateForm($request, $id);

        $freight = Freight::find($id);
        

        $edtFormat = Carbon::createFromFormat('d/m/Y', $request['edt'])->toDateString();
        $request['edt'] = $edtFormat;

        $etaFormat = Carbon::createFromFormat('d/m/Y', $request['eta'])->toDateString();
        $request['eta'] = $etaFormat;

        $request['state'] = "Numerado";

        $freight->fill($request->all());
        $freight->save();

        return redirect('freight');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function validateForm($request, $id){
        $request->validate([
            'roi' => 'required|string|unique:freight,roi,' . $id
        ]);
    
    }


}
