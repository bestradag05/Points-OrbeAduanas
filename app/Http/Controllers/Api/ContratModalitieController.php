<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContractModalitie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContratModalitieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contract_modalities = ContractModalitie::all();

        return response()->json([
            "contract_modalities" => $contract_modalities->map(function ($contract) {
                return [
                    "id" => $contract->id,
                    "name" => $contract->name,
                    "description" => $contract->description,
                    "state" => $contract->state
                ];
            }),
        ], 200);
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

       
        $exist_personal = ContractModalitie::where("name", $request->name)->first();

        if ($exist_personal) {
            return response()->json([
                "message" => "Ya existe una modalidad de contratacion con este nombre"
            ], 403);
        }


        if($request->hasFile('format')){
            $file = $request->file('format');
            $path = $file->store('formatos_contrato', 'public');
        }

        ContractModalitie::create([
            'name' => $request->name,
            "description" => $request->description,
            "format" => $path,
            'state' => 'Activo'
        ]);

        return response()->json([
            "message" => "Modalidad de contrato registrado",
        ], 200);

        

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contract_modalities = ContractModalitie::findOrFail($id);
        

        return response()->json([
            "id" => $contract_modalities->id,
            "name" => $contract_modalities->name,
            "description" => $contract_modalities->description,
            "state" => $contract_modalities->state
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContractModalitie $contractModalitie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contract_modalities = ContractModalitie::findOrFail($id);


        if($request->hasFile('format')){

            if ($contract_modalities->format) {
                Storage::delete($contract_modalities->format);
            }

            $file = $request->file('format');
            $path = $file->store('formatos_contrato', 'public');

            $contract_modalities->format = $path;

        }


        $contract_modalities->update($request->except('format'));

        return response()->json([
            "message" =>  'Se actulizo la modalidad de contratacion'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contract_modalities = ContractModalitie::findOrFail($id);

        $contract_modalities->update(['state' => 'Inactivo']);
        return response()->json([
            "message" => 'La modalidad de contratacion fue eliminada',
            "state" => 'Inactivo'
        ], 200);
    }
}
