<?php

namespace App\Http\Controllers;

use App\Models\AdditionalPoints;
use App\Models\ConceptCustoms;
use App\Models\Concepts;
use App\Models\Custom;
use App\Models\Customer;
use App\Models\Insurance;
use App\Models\Modality;
use App\Models\TypeShipment;
use App\Services\CustomService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\PdfToText\Pdf;
use stdClass;

class CustomController extends Controller
{

    protected $customService;

    public function __construct(CustomService $customService)
    {
        $this->customService = $customService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Listar aduanas

        $customs = Custom::all()->load('routing.personal', 'modality');


        $heads = [
            '#',
            'N° Operacion',
            'Asesor',
            'Modalidad',
            'Estado',
            'Acciones'
        ];



        return view("custom/list-custom", compact("customs", "heads"));
    }

    public function getCustomPending()
    {

        //Listar aduanas

        $customs = Custom::where('state', 'Pendiente')->get()->load('routing.personal', 'modality');

        $heads = [
            '#',
            'N° Operacion',
            'Asesor',
            'Modalidad',
            'Estado',
            'Acciones'
        ];


        return view("custom/pending-list-custom", compact("customs", "heads"));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Redireccion al formulario para crear una aduana


        $customers = Customer::all();
        $type_shipments = TypeShipment::all();
        $modalitys = Modality::all();

        return view("custom/register-custom", compact('customers', 'type_shipments', 'modalitys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       $custom = $this->customService->storeCustom($request);

        return redirect('commercial/quote/' . $custom->commercial_quote->id . '/detail');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mostamos el formulario para completar 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Obtenemos el registro que se va editar

        $compact = $this->customService->editCustom($id);

        return view('custom/edit-custom', $compact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Se actualiza la aduana

        $custom = $this->customService->updateCustom($request, $id);

        return redirect('commercial/quote/' . $custom->commercial_quote->id . '/detail');
    }


    public function parseDouble($num)
    {

        $valorDecimal = (float)str_replace(',', '', $num);

        return $valorDecimal;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /*     public function loadDocument(Request $request){

        if (!$request->hasFile('doc_custom')) {
            return response()->json(['mensaje' => 'No se ha proporcionado un archivo PDF'], 400);
        }

        // Obtener el archivo PDF de la solicitud
        $pdfFile = $request->file('doc_custom');

    
        $pdfFileName = uniqid() . '.' . $pdfFile->getClientOriginalExtension();

        // Mover el archivo PDF a la carpeta temporal
        $pdfFile->storeAs('pdf_temp', $pdfFileName);

        $textoCompleto = Pdf::getText('pdf/'.$pdfFileName, 'C:\Program Files\Git\mingw64\bin/pdftotext');
        
        $posicionInicio = strpos($textoCompleto, utf8_decode('No Declaración'));


        if ($posicionInicio !== false) {
            // Avanzar la posición de inicio a la posición justo después de la palabra "No Declaración"
            $posicionInicio += strlen('No Declaración ');
        
            // Buscar la posición del próximo salto de línea después de la posición de inicio
            $posicionSaltoLinea = strpos($textoCompleto, "\r\n", $posicionInicio);
        
            if ($posicionSaltoLinea !== false) {
                // Extraer el texto que sigue después de la palabra "No Declaración" hasta el próximo salto de línea
                $textoDespues = substr($textoCompleto, $posicionInicio, $posicionSaltoLinea - $posicionInicio);
        
    
            } else {
                echo "No se encontró el próximo salto de línea después de la palabra 'No Declaración'.";
            }
        } else {
            echo "No se encontró la palabra 'No Declaración' en el texto.";
        }

        return false;
    }
 */
    public function validateForm($request, $id)
    {
        $request->validate([
            'nro_orde' => 'required|string|unique:custom,nro_orde,' . $id,
            'nro_dua' => 'required|string|unique:custom,nro_dua,' . $id,
            'nro_dam' => 'string|unique:custom,nro_dam,' . $id,
            'date_register' => 'required|string',
            'cif_value' => 'required',
            'channel' => 'required|string',
            'nro_bl' => 'required|string',
        ]);
    }
}
