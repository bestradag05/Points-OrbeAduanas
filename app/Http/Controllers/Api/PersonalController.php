<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->search;

        $personals = Personal::where("names", "like", "%" . $name . "%")->orderBy("id", "desc")->get();

        return response()->json([
            "personals" => $personals->map(function ($personal) {
                return [
                    "id" => $personal->id,
                    "document_number" => $personal->document_number,
                    "names" => $personal->names,
                    "last_name" => $personal->last_name,
                    "mother_last_name" => $personal->mother_last_name,
                    "cellphone" => $personal->cellphone,
                    "email" => $personal->email,
                    "state" => $personal->state,
                    "img_url" => $personal->img_url ? env("APP_URL") . "storage/" . $personal->img_url : env("APP_URL") . "storage/personals/user_default.png",
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

        $exist_personal = Personal::where("document_number", $request->document_number)->first();

        if ($exist_personal) {
            return response()->json([
                "message" => "Ya existe un usuario con este numero de documento"
            ], 403);
        }

        //Consultamos si tiene usuario

        if ($request->email && $request->password) {

            $exist_usuario = User::where("email", $request->email)->first();

            if ($exist_usuario) {
                return response()->json([
                    "message" => "Este correo ya esta asignado a un usuario"
                ], 403);
            }

            $user = User::create([
                'email' => $request->email,
                'password' => $request->password
            ]);
        }


        // "Fri Oct 08 1993 00:00:00 GMT-0500 (hora estándar de Perú)"
        // Eliminar la parte de la zona horaria (GMT-0500 y entre paréntesis)
        $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '', $request->birth_date);

        $request->birthdate =  Carbon::parse($date_clean)->format("Y-m-d h:i:s");

        if ($request->hasFile("img_url")) {
            $path = Storage::putFile("personals", $request->file("img_url"));
            $request->img_url = $path;
        }

        if ($request->password) {
            $request->password = bcrypt($request->password);
        }

        Personal::create([
            'document_number' => $request->document_number,
            'id_document' => $request->id_document,
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
            'id_user'  => (isset($user)) ? $user->id : null,
        ]);


        return response()->json([
            "message" => "Se creo un nuevo personal",
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $personal = Personal::findOrFail($id);
        return response()->json([
            "id" => $personal->id,
            "document_number" => $personal->document_number,
            "id_document" => $personal->id_document,
            "names" => $personal->names,
            "last_name" => $personal->last_name,
            "mother_last_name" => $personal->mother_last_name,
            "birthdate" => $personal->birthdate,
            "civil_status" => $personal->civil_status,
            "sexo" => $personal->sexo,
            "cellphone" => $personal->cellphone,
            "email" => $personal->email,
            "user" => $personal->user,
            "state" => $personal->state,
            "img_url" => $personal->img_url ? env("APP_URL") . "storage/" . $personal->img_url : env("APP_URL") . "storage/personals/user_default.png",
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

        return response()->json([
            "message" => $request->all()
        ], 200);
        $is_personal = Personal::where("id", "<>", $id)->where("document_number", $request->document_number)->first();

        if ($is_personal) {
            return response()->json([
                "message" => "Ya existe este personal con este numero de identificacion"
            ], 403);
        }

        $personal = Personal::findOrFail($id);

        if($request->hasFile("imagen")){
            if($personal->img_url){
                Storage::delete($personal->img_url);
            }

            $path = $request->file('imagen')->store('personals');
           
            $request->request->add(["img_url" => $path]);

        }

        $personal->update($request->all()); 

        return response()->json([
            "message" => "Personal actualizado"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
