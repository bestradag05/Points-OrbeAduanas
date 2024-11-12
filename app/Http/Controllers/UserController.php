<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $heads = [
            'ID',
            'Email',
            'password'
        ];

        return view("users/list-users", compact("users", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view("users/register-user");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateForm($request, null);


        User::create([$request->all()]);


        return redirect('users');


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


    public function validateForm($request, $id)
    {

        $request->validate([
            'email' => 'required|string|unique:users,email,' . $id,
            'password' => 'required|string',
            'password_confirm' => 'required|string|same:password',
        ], [
            'password_confirm.same' => 'Las contraseñas no coinciden.',
        ]);
    }



}
