<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        $name = $request->search;

        $documents = Document::where("name","like","%".$name."%")->orderBy("id","desc")->get();

        return response()->json([
            "documents" => $documents->map(function($document) {
                return [
                    "id" => $document->id,
                    "name" => $document->name,
                    "number_digits" => $document->number_digits,
                    "state" => $document->state
                ];
            }),
        ]);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $exist_document = Document::where("name", $request->name)->first();

        if($exist_document){
            return response()->json([
                "message" => 403,
                "message_text" => "EL NOMBRE DEL DOCUMENTO YA EXISTE"
            ]);
        }

        Document::create([
            'name' => $request->name,
            'number_digits' => $request->number_digits,
            'state' => 'Activo'
        ]);

        return response()->json([
            "message" => 200,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $document = Document::findOrFail($id);
        return response()->json([
            "id" => $document->id,
            "name" => $document->name,
            "number_digits" => $document->number_digits,
            "state" => $document->state,
            "created_at" => $document->created_at->format("Y-m-d h:i:s")
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $is_document = Document::where("id","<>",$id)->where("name",$request->name)->first();

        if($is_document){
            return response()->json([
                "message" => 403,
                "message_text" => "EL NOMBRE DEL ROL YA EXISTE"
            ]);
        }

        $document = Document::findOrFail($id);

        $document->update($request->all());
        return response()->json([
            "message" => 200,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = Document::findOrFail($id);
        /* if($document->personal->count() > 0){
            return response()->json([
                "message" => 403,
                "message_text" => "EL ROL SELECCIONADO NO SE PUEDE ELIMINAR POR MOTIVOS QUE YA TIENE USUARIOS RELACIONADOS"
            ]);
        } */
        $document->delete();
        return response()->json([
            "message" => 200,
        ]);
    }
}
