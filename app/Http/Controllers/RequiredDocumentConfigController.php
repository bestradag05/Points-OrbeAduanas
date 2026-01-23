<?php

namespace App\Http\Controllers;

use App\Models\RequiredDocumentConfig;
use App\Models\TypeService;
use Illuminate\Http\Request;

class RequiredDocumentConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = RequiredDocumentConfig::orderBy('service_type')
            ->orderBy('order')
            ->paginate(15);

        $heads = [
            'Servicio',
            'Documento',
            'Requerido',
            'Auto-Generado',
            'Orden',
            'Descripción',
            'Acciones'
        ];

        return view('required-documents.list-required-documents', compact('documents', 'heads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $serviceTypes = TypeService::all()->pluck('name')->toArray();
        return view('required-documents.register-required-documents', compact('serviceTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_type' => 'required',
            'document_name' => 'required|string|max:255',
            'is_required' => 'boolean',
            'is_auto_generated' => 'boolean',
            'order' => 'integer|min:0',
            'description' => 'nullable|string',
        ]);

        RequiredDocumentConfig::create($validated);

        return redirect()->route('required-documents.index')
            ->with('success', 'Documento requerido creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $document = RequiredDocumentConfig::find($id);

        if (!$document) {
            return redirect()->route('required-documents.index')
                ->with('error', 'Documento no encontrado');
        }

        $serviceTypes = TypeService::all()->pluck('name')->toArray();
        return view('required-documents.edit-required-documents', [
            'document' => $document,
            'serviceTypes' => $serviceTypes
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $document = RequiredDocumentConfig::find($id);

        if (!$document) {
            return redirect()->route('required-documents.index')
                ->with('error', 'Documento no encontrado');
        }

        $validated = $request->validate([
            'service_type' => 'required',
            'document_name' => 'required|string|max:255',
            'is_required' => 'boolean',
            'is_auto_generated' => 'boolean',
            'order' => 'integer|min:0',
            'description' => 'nullable|string',
        ]);

        $document->update($validated);

        return redirect()->route('required-documents.index')
            ->with('success', 'Documento requerido actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $document = RequiredDocumentConfig::find($id);

        if (!$document) {
            return redirect()->route('required-documents.index')
                ->with('error', 'Documento no encontrado');
        }

        $document->delete();

        return redirect()->route('required-documents.index')
            ->with('success', 'Documento requerido eliminado correctamente');
    }
}
