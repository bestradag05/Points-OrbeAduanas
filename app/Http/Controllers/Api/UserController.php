<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        $users = User::where("email","like","%".$email."%")->orderBy("id","desc")->get();

        return response()->json([
            "users" => $users->map(function($user) {
                return [
                    "id" => $user->id,
                    "email" => $user->email,
                    "state" => $user->state,
                    "personal" => $user->personal,
                    "img_url" => $user->personal->img_url ? env("APP_URL") . "storage/" . $user->personal->img_url : env("APP_URL") . "storage/personals/user_default.png",
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
