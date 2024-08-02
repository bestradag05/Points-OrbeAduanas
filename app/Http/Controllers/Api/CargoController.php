<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!auth('api')->user()->can('list_rol')){
            return response()->json(["message"=>"EL USUARIO NO ESTA AUTORIZADO"],403);
        }

        $name=$request->search;

        $cargos=Cargo::where("name","like","%".name."%")->orderBy("id","desc")->get();
        
        return response()->json([
            "roles"=> $cargos->map(function($cargo){

                return[
                    "id"=> $cargo->id,
                    "nombre"=>$cargo->nombre,
                    "CodUsuarioR"=>$cargo->CodUsuarioR,
                    "Registro"=>$cargo->Registro->format("Y-m-d h:i:s"),
                    "CodUsuarioE"=>$cargo->$CodUsuarioE,
                    "RegistroE"=>$cargo->RegistroE->format("Y-m-d h:i:s"),
                    "estado"=>$cargo->estado
                ];
            }),

        ]);
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
        if(!auth('api')->user()->can('edit-rol')){
            return response()->json(["message"=>"EL USUARIO NO ESTA AUTORIZADO"],403);
        }
        $cargo=Cargo::finOrFail($id);
        return response()->json([

            "id"=> $cargo->id,
                    "nombre"=>$cargo->nombre,
                    "CodUsuarioR"=>$cargo->CodUsuarioR,
                    "Registro"=>$cargo->Registro->format("Y-m-d h:i:s"),
                    "CodUsuarioE"=>$cargo->$CodUsuarioE,
                    "RegistroE"=>$cargo->RegistroE->format("Y-m-d h:i:s"),
                    "estado"=>$cargo->estado

        ]);
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
        if(!auth('api')->user()->can('delete_rol')){
            return response()->json(["message"=>"EL USUARIO NO ETSA AUTORIZADO"],403);
        }
        $cargo=Cargo::finOrFail($id);
        if($cargo->users->count()>0){
            return response()->json([
                "message"=> 403,
                "message_text" => ""
            ]);
        }
    }
}
