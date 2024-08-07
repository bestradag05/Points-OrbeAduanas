<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personal;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $exist_personal = Personal::where("document_number", $request->document_number)->first();

        if($exist_personal){
            return response()->json([
                "message" => 403,
                "message_text" => "ESTE PERSONAL YA HA SIDO REGISTRADO"
            ]);
        }

        return response()->json([
            "message" => "paso la validacion",
        ]);

        Personal::create([
            'document_number' => $request->document_number,
            'names' => $request->names,
            'last_name' => $request->last_name,
            'mother_last_name' => $request->mother_last_name,
            'birthdate' => $request->birthdate,
            'civil_status' => $request->civil_status,
            'sexo' => $request->sexo,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
            'img_url'  => $request->img_url,
            'state'  => $request->state,
            'id_user'  => $request->id_user,
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
