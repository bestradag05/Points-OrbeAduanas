<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras;
use PhpOffice\PhpWord\TemplateProcessor;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::all();

        return response()->json([
            "contracts" => $contracts->map(function ($contract) {
                return [
                    "id" => $contract->id,
                    "personal" => $contract->personal,
                    "img_url" => $contract->personal->img_url ? env("APP_URL") . "storage/" . $contract->personal->img_url : env("APP_URL") . "storage/personals/user_default.png",
                    "contract_modality" => $contract->contract_modality,
                    "start_date" => $contract->start_date,
                    "end_date" => $contract->end_date,
                    "salary" => $contract->salary,
                    "state" => $contract->state
                ];
            }),
        ], 200);
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

        $formattedDateStart =  $this->formatdateUTC($request->start_date);
        $formattedDateEnd =  $this->formatdateUTC($request->end_date);

        $request->merge([
            'start_date' => $formattedDateStart,
            'end_date' => $formattedDateEnd
        ]);

        Contract::create([
            'id_personal' => $request->id_personal,
            "id_contract_modality" => $request->contract_modality,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'salary' => $request->salary,
            'id_cargo' => $request->id_cargo,
            'id_company' => $request->id_company,
            'id_contract_modalities' => $request->id_contract_modalities,
            'functions' =>  json_encode($request->functions),
            'state' => 'Pendiente'
        ]);

        return response()->json([
            "message" => "Contrato registrado",
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contract = Contract::findOrFail($id);

        return response()->json([
            "id" => $contract->id,
            "personal" => $contract->personal,
            "cargo" => $contract->cargo,
            "company" => $contract->company,
            "document" => $contract->personal->document,
            "img_url" => $contract->personal->img_url ? env("APP_URL") . "storage/" . $contract->personal->img_url : env("APP_URL") . "storage/personals/user_default.png",
            "contract_modalities" => $contract->contractModalities,
            "start_date" => $contract->start_date,
            "end_date" => $contract->end_date,
            "salary" => $contract->salary,
            "state" => $contract->state
        ], 200);
    }

    public function getDocumentContract(string $id){


        $contract = Contract::findOrFail($id);
        
        $filePath = storage_path('app/public/' . $contract->contractModalities->format);

    
        if(!Storage::exists($contract->contractModalities->format)){
            return response()->json(['message' => 'Archivo no encontrado']);
        }
       

        $templateProcessor = new TemplateProcessor($filePath);

        $full_name = $contract->personal->names. ' ' . $contract->personal->last_name . ' ' . $contract->personal->mother_last_name;
        $templateProcessor->setValue('nombres', strtoupper($full_name));
        $templateProcessor->setValue('tipo_documento', $contract->personal->document->name);
        $templateProcessor->setValue('numero_documento', $contract->personal->document_number);
        $templateProcessor->setValue('direccion', $contract->personal->address);
        $templateProcessor->setValue('empresa', strtoupper($contract->company->business_name));
        $templateProcessor->setValue('ruc', $contract->company->ruc);
        $templateProcessor->setValue('representante_legal', strtoupper($contract->company->manager));
        $templateProcessor->setValue('dni_representante', $contract->company->ruc);

        //Conversion de fechas
        $date_start = Carbon::parse($contract->start_date);
        $end_start = Carbon::parse($contract->end_date);
        $formattedDateStart = $date_start->format('d/m/Y');
        $formattedDateEnd = $end_start->format('d/m/Y');
        
        $templateProcessor->setValue('duracion', $formattedDateStart . ' hasta el ' . $formattedDateEnd);
        $templateProcessor->setValue('cargo', $contract->cargo->name);
        $templateProcessor->setValue('sueldo', 'S/.' . $contract->salary);
        $text_salary  = new NumeroALetras();
        $text_salary_format = $text_salary->toMoney( $contract->salary, 2, 'SOLES');
        $templateProcessor->setValue('sueldo_texto', '( '.$text_salary_format.')');

        //Modificando horario

        $schedule = $contract->personal->timeschedule->first();

        $daysOfWeek = [
            'Lunes' => ['he' => $schedule->heLunes, 'hs' => $schedule->hsLunes],
            'Martes' => ['he' => $schedule->heMartes, 'hs' => $schedule->hsMartes],
            'Miércoles' => ['he' => $schedule->heMiercoles, 'hs' => $schedule->hsMiercoles],
            'Jueves' => ['he' => $schedule->heJueves, 'hs' => $schedule->hsJueves],
            'Viernes' => ['he' => $schedule->heViernes, 'hs' => $schedule->hsViernes],
            'Sábado' => ['he' => $schedule->heSabado, 'hs' => $schedule->hsSabado],
        ];

        $groupedDays = [];

        foreach ($daysOfWeek as $day => $times) {
            if ($times['he'] && $times['hs']) {
                $formattedEntry = date('h:i a', strtotime($times['he']));
                $formattedExit = date('h:i a', strtotime($times['hs']));
    
                $key = $formattedEntry . ' a ' . $formattedExit;
                
                $groupedDays[$key][] = $day;
            }
        }


        $output = '';


        foreach ($groupedDays as $timeRange => $days) {
            // Convertir el array de días a una cadena con formato adecuado (Lunes, Martes y Miércoles)
            $formattedDays = implode(', ', array_slice($days, 0, -1));

            if (count($days) > 1) {
                $formattedDays .= ' y ' . end($days);
            } else {
                $formattedDays = $days[0];
            }
    
            $output .= $formattedDays . ' de ' . $timeRange . "\n";
        }
    

        dd($output);
       

        //Listar las funciones del trabajador
        $functions = '';

        foreach (json_decode($contract->functions) as $index => $function) {
            // Agrega un punto de bala y el texto de la función
            $functions .= "• " . $function;
            
            // Añade un salto de línea solo si no es el último elemento
            if ($index < count(json_decode($contract->functions)) - 1) {
                $functions .= "\n";
            }
        }

        $templateProcessor->setValue('funciones' , $functions);

        $directory = 'contracts';
        $outputPath = $directory . '/' . $contract->personal->document_number . '.docx';
       
        // Crear el directorio si no existe
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }
       
        // Guardar el archivo en el directorio
        $templateProcessor->saveAs(storage_path('app/public/' . $outputPath));
    
       

       

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
        $contract = Contract::findOrFail($id);

        $formattedDateStart =  $this->formatdateUTC($request->start_date);
        $formattedDateEnd =  $this->formatdateUTC($request->end_date);

        $request->merge([
            'start_date' => $formattedDateStart,
            'end_date' => $formattedDateEnd
        ]);

        $contract->update($request->all());

        return response()->json([
            "message" => "Contrato actualizado"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function formatdateUTC($date)
    {

        $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '', $date);
        $dateFormat =   Carbon::parse($date_clean)->format("Y-m-d h:i:s");
        return $dateFormat;
    }
}
