<?php

namespace App\Http\Controllers;

use App\Models\Custom;
use App\Models\Freight;
use App\Models\ProcessManagement;
use App\Models\Transport;
use App\Services\ProcessManagementService;
use Illuminate\Http\Request;

class ProcessManagementController extends Controller
{
    protected $processManagementService;

    public function __construct(ProcessManagementService $processManagementService)
    {
        $this->processManagementService = $processManagementService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compact = $this->processManagementService->index();
        return view('process_management.list-process-management', $compact);
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
    public function show(ProcessManagement $process)
    {
        $commercialQuote = $process->commercialQuote;

        $services = [];

        // Verificar y agregar el servicio 'freight' con su nombre y estado
        if ($commercialQuote->freight()->exists()) {
            $services['freight'] = [
                'name' => 'Freight',  // Nombre del servicio
                'id' => $commercialQuote->freight->id,
                'status' => $commercialQuote->freight->status // Estado del servicio
            ];
        }

        // Verificar y agregar el servicio 'custom' con su nombre y estado
        if ($commercialQuote->custom()->exists()) {
            $services['custom'] = [
                'name' => 'Custom',  // Nombre del servicio
                'id' => $commercialQuote->custom->id,
                'status' => $commercialQuote->custom->status // Estado del servicio
            ];
        }

        // Verificar y agregar el servicio 'transport' con su nombre y estado
        if ($commercialQuote->transport()->exists()) {
            $services['transport'] = [
                'name' => 'Transport',  // Nombre del servicio
                'id' => $commercialQuote->transport->id,
                'status' => $commercialQuote->transport->status // Estado del servicio
            ];
        }



        return view('process_management.detail-process-management', compact('process', 'services'));
    }

    public function getStepContent($step, Request $request)
    {
        // Obtener el ID del servicio desde los parámetros de la solicitud
        $serviceId = $request->query('id');  // Obtiene el parámetro 'id'

        // Dependiendo del servicio, carga el contenido correspondiente
        switch ($step) {
            case 'freight':
                // Obtener el servicio 'freight' con el ID
                $freight = Freight::with('documents')->findOrFail($serviceId); // Buscar el servicio 'freight' por ID
                $commercialQuote = $freight->commercial_quote;

                $lastNotification = null;

                if ($freight->state === 'Notificado') {
                    $lastNotification = auth()->user()->notifications()
                        ->where('data->freight_id', $freight->id)
                        ->latest()
                        ->first();
                }

                if (!$freight) {
                    abort(404);  // Si no se encuentra, abortar
                }
                return view('process_management.services.form-freight-services', compact('freight', 'commercialQuote', 'lastNotification'));

            case 'custom':
                // Obtener el servicio 'custom' con el ID
                $custom = Custom::with('documents')->findOrFail($serviceId); // Buscar el servicio 'custom' por ID
                $commercialQuote = $custom->commercial_quote;

                if (!$custom) {
                    abort(404);  // Si no se encuentra, abortar
                }
                return view('process_management.services.form-custom-services', compact('custom', 'commercialQuote'));

            case 'transport':
                // Obtener el servicio 'transport' con el ID
                $transport = Transport::with('documents')->findOrFail($serviceId); // Buscar el servicio 'transport' por ID
                $commercialQuote = $transport->commercial_quote;

                if (!$transport) {
                    abort(404);  // Si no se encuentra, abortar
                }
                return view('process_management.services.form-transport-services', compact('transport', 'commercialQuote'));

            default:
                abort(404);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProcessManagement $processManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProcessManagement $processManagement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProcessManagement $processManagement)
    {
        //
    }
}
