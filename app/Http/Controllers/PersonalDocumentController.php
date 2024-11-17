<?php

namespace App\Http\Controllers;

use App\Models\PersonalDocument;
use Illuminate\Http\Request;

class PersonalDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = PersonalDocument::all();

        $heads = [
            '#',
            'Nombre',
            'Numero de Digitos',
            'Estado',
            'Acciones'
        ];

        return view("personal_documents/list-personal-document", compact("documents", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("personal_documents/register-personal-document");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateForm($request, null);

        PersonalDocument::create([
            'name' => $request->name,
            'number_digits' => $request->number_digits,
            'state' => 'Activo'
        ]);

        return redirect('personal_document');
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
        $personal_document = PersonalDocument::findOrFail($id);

        return view("personal_documents/edit-personal-document", compact('personal_document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateForm($request, $id);

        $is_document = PersonalDocument::where("id", "<>", $id)->where("name", $request->name)->first();
        

        if ($is_document) {

            return redirect()->back()->withErrors(['name' => 'Ya se registro este documento.'])->withInput();
        }

    


        $personal_document = PersonalDocument::findOrFail($id);



        $personal_document->update($request->all());

        return redirect('personal_document');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $personal_document = PersonalDocument::find($id);
        $personal_document->update(['state' => 'Inactivo']);

        return redirect('personal_document')->with('eliminar', 'ok');
    }


    public function validateForm($request, $id)
    {


        $request->validate([
            'name' => 'required|string',
            'number_digits' => 'required|string'

        ]);
    }
}
