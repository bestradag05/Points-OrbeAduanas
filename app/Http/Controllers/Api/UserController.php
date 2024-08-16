<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personal;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $email = $request->search;

        $users = User::where("email", "like", "%" . $email . "%")->orderBy("id", "desc")->get();

        return response()->json([
            "users" => $users->map(function ($user) {
                return [
                    "id" => $user->id,
                    "email" => $user->email,
                    "state" => $user->state,
                    "personal" => isset($user->personal) ? $user->personal : '',
                    "img_url" => isset($user->personal->img_url) && $user->personal->img_url != ""  ? env("APP_URL") . "storage/" . $user->personal->img_url : env("APP_URL") . "storage/personals/user_default.png",
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
      
        $exist_user = User::where("email", $request->email)->first();

        if ($exist_user) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL USUARIO YA EXISTE"
            ]);
        }


        $user = User::create([
            'email' => $request->email,
            'password' => $request->password,
            'state' => $request->state
        ]);

        if($request->id_personal){
            $personal = Personal::findOrFail($request->id_personal);

            $personal->update(['id_user' => $user->id ]);
        }

        return response()->json([
            "message" => "El usuario se registro",
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            "id" => $user->id,
            "email" => $user->email,
            "state" => $user->state
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

        
        return response()->json([
            'response' => $request->all()
        ]);

        $is_document = User::where("id","<>",$id)->where("email",$request->email)->first();

        if($is_document){
            return response()->json([
                "message" => 403,
                "message_text" => "El Email ya esta asignado a otro usuario"
            ]);
        }

        $user = User::findOrFail($id);

      

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
