<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->search;

        $customers = Customer::all();

        return response()->json([
            "customers" => $customers->map(function($customer) {
                return [
                   'document_number' => $customer->document_number,
                   'name_businessname' => $customer->name_businessname,
                   'address' => $customer->address,
                   'contact_name' => $customer->contact_name,
                   'contact_number' => $customer->contact_number,
                   'contact_email' => $customer->contact_email,
                   'state' => $customer->state,
                   'id_document' => $customer->id_document,
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
