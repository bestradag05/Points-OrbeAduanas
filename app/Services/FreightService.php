<?php

namespace App\Services;

use App\Models\AdditionalPoints;
use App\Models\CommercialQuote;
use App\Models\Concept;
use App\Models\ConceptFreight;
use App\Models\Freight;
use App\Models\Insurance;
use App\Models\QuoteFreight;
use App\Models\TypeInsurance;
use App\Models\TypeService;
use App\Notifications\NotifyFreight;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class FreightService
{

    protected $freightDocumentService;

    public function __construct(FreightDocumentService $freightDocumentService)
    {
        $this->freightDocumentService = $freightDocumentService;
    }


    public function index()
    {
        $freights = Freight::all();


        $heads = [
            '#',
            'N° Operacion',
            'Asesor Comercial',
            'Utilidad a Orbe',
            'Estado',
            'Acciones'
        ];



        return compact("freights", "heads");
    }


    public function getFreightPending()
    {

        $freights = Freight::where('state', 'Pendiente')->get()->load('routing.personal');

        $heads = [
            '#',
            'N° Operacion',
            'Asesor Comercial',
            'Utilidad a Orbe',
            'Estado',
            'Acciones'
        ];


        return compact("freights", "heads");
    }

    public function getFreightPersonal()
    {

        $personalId = Auth::user()->personal->id;

        // Verificar si el usuario es un Super-Admin
        if (Auth::user()->hasRole('Super-Admin')) {
            // Si es Super-Admin, obtener todos los routing
            $freights = Freight::with('quoteFreight')->get();
        } else {
            // Si no es Super-Admin, solo obtener los clientes que pertenecen al personal del usuario autenticado
            $freights = Freight::whereHas('commercial_quote', function ($query) use ($personalId) {
                $query->where('id_personal', $personalId);
            })->with('quoteFreights')->get();
        }

        $heads = [
            '#',
            'Cliente',
            'Origen',
            'Destino',
            'Utilidad a Orbe',
            'Valor del Flete',
            'Seguro',
            'N° Cotizacion',
            'Asesor Comercial',
            'Estado',
            'Acciones'
        ];



        return  compact("freights", "heads");
    }



    public function getTemplateGeneratePointFreight($id)
    {

        // Obtenemos el registro que se va editar

        $freight = Freight::find($id);
        $value_freight = 0;

        /* $freight->load('concepts'); */

        foreach ($freight->concepts as $concept) {
            $value_freight += $concept->pivot->value_concept;
        }

        return compact('freight', 'value_freight');
    }


    public function updatePointFreight(Request $request, string $id)
    {

        $freight = Freight::find($id);


        $dateRegisterFormat = Carbon::createFromFormat('d/m/Y', $request['edt'])->toDateString();
        $request['date_register'] = $dateRegisterFormat;

        $edtFormat = Carbon::createFromFormat('d/m/Y', $request['edt'])->toDateString();
        $request['edt'] = $edtFormat;

        $etaFormat = Carbon::createFromFormat('d/m/Y', $request['eta'])->toDateString();
        $request['eta'] = $etaFormat;

        $request['state'] = "Generado";

        $freight->fill($request->all());
        $freight->save();
    }



    public function createFreight($quoteId)
    {

        $quote = QuoteFreight::findOrFail($quoteId);
        $acceptedResponse = $quote->responses()->where('status', 'Aceptado')->first();
        $commercial_quote = $quote->commercial_quote;
        $type_insurace = TypeInsurance::with('insuranceRate')->get();
        $concepts = Concept::all();

        return compact('quote', 'type_insurace', 'concepts', 'commercial_quote', 'acceptedResponse');
    }


    public function storeFreight($request)
    {
        //Convertimos el json a un objeto
        $concepts = json_decode($request->concepts);

        $freight = $this->createOrUpdateFreight($request);

        $insurance = $this->createOrUpdateInsurance($request, $freight);


        if ($insurance) {
            $concepts = $this->updateConceptInsurance($concepts, $freight, $request);
        }

        //Relacionamos los conceptos que tendra este flete

        $this->syncFreightConcepts($freight, $concepts);

        //Actualizamos el valor CIF para la cotizacion:

        $commercial_quote = CommercialQuote::where("nro_quote_commercial", $request->nro_quote_commercial)->first();

        $cif_value = $this->parseDouble($freight->value_sale) + $this->parseDouble($insurance ? $insurance->sales_value : 0) + $this->parseDouble($commercial_quote ? $commercial_quote->load_value : 0);

        $commercial_quote->update(['cif_value' => $cif_value]);

        return $freight;
    }


    public function generateNofity($request)
    {
        //Debemos buscar al usuario que se notificara 

        $freight = Freight::with('commercial_quote.personal.user')->findOrFail($request->id_freight);
        $user = $freight->commercial_quote->personal->user;

        $user->notify(new NotifyFreight($freight, $request->message_freight));

        $freight->update(['state' => 'Notificado']);
    }


    public function generateRoutingOrder($request)
    {
        $freight = Freight::findOrFail($request->id_freight);
        $commercialQuote = $freight->commercial_quote;
        $concepts = $freight->concepts;

        $freight->update(['wr_loading' => $request->wr_loading]);
        $pdf = Pdf::loadView('freight.pdf.routingOrder', compact('commercialQuote', 'concepts', 'freight'));
        $filename = 'Routing Order.pdf';

        $this->freightDocumentService->storeFreightDocument($freight, $pdf->output(), $filename);

        return compact('freight', 'commercialQuote');
    }

    public function editFreight(string $id)
    {

        $freight = Freight::with('concepts')->find($id);
        $quote = $freight->quoteFreight;
        $acceptedResponse = $freight->quoteFreight->responses()->where('status', 'Aceptado')->first();

        $commercial_quote = $freight->commercial_quote;
        $insurance = null;

        if ($freight->insurance()->exists()) {
            $insurance = $freight->insurance;
        }

        $type_insurace = TypeInsurance::with('insuranceRate')->get();
        $concepts = Concept::all();

        $conceptFreight = null;

        foreach ($concepts as $concept) {

            if ($freight->commercial_quote->type_shipment->id === $concept->id_type_shipment && $concept->typeService->name == 'Flete' && $concept->name === 'OCEAN FREIGHT') {
                $conceptFreight = $concept;
            }

            if ($freight->commercial_quote->type_shipment->id === $concept->id_type_shipment && $concept->typeService->name == 'Flete' && $concept->name === 'AIR FREIGHT') {
                $conceptFreight = $concept;
            }
        }


        return compact('freight', 'quote', 'type_insurace', 'concepts', 'conceptFreight', 'commercial_quote', 'insurance', 'acceptedResponse');
    }

    public function showFreight($id)
    {
        $freight = Freight::with('documents')->findOrFail($id);
        $commercialQuote = $freight->commercial_quote;

        $lastNotification = null;

        if ($freight->state === 'Notificado') {
            $lastNotification = auth()->user()->notifications()
                ->where('data->freight_id', $freight->id)
                ->latest()
                ->first();
        }


        return compact('freight', 'commercialQuote', 'lastNotification');
    }


    public function uploadFreightFiles($request, $id)
    {
        $freight = Freight::findOrFail($id);
        // Validar que venga el archivo
        if (!$request->hasFile('file')) {
            return redirect()->route('freight.show', $freight->id)->with('error', 'Hubo un error, el archivo no se pudo cargar');
        }


        $file = $request->file('file');
        $content = file_get_contents($file);
        $nameForDB = $request->name_file;
        $extension = $file->getClientOriginalExtension();

        $this->freightDocumentService->storeFreightDocument($freight, $content, $nameForDB, $extension);
    }


    public function updateFreight($request, $id)
    {
        $concepts = json_decode($request->concepts);

        $freight = $this->createOrUpdateFreight($request, $id);

        $insurance = $this->createOrUpdateInsurance($request, $freight);

        if ($insurance) {
            $concepts = $this->updateConceptInsurance($concepts, $freight, $request);
        }

        //Relacionamos los conceptos que tendra este flete

        $this->syncFreightConcepts($freight, $concepts);

        $commercial_quote = CommercialQuote::where("nro_quote_commercial", $request->nro_quote_commercial)->first();

        $cif_value = $this->parseDouble($freight->value_freight) + $this->parseDouble($insurance ? $insurance->insurance_sale : 0) + $this->parseDouble($commercial_quote ? $commercial_quote->load_value : 0);

        $commercial_quote->update(['cif_value' => $cif_value]);


        return $freight;
    }



    public function createOrUpdateFreight(Request $request, $id = null)
    {
        $freight = $id ? Freight::findOrFail($id) : new Freight();
        //Para vincular el servicio de flete a la tabla
        $commercial = CommercialQuote::where('nro_quote_commercial', $request->nro_quote_commercial)->first();

        $typeService = TypeService::where('name', 'Flete')->first();

        if ($commercial && $typeService) {
            if ($id) {
                // Si es una edición, aseguramos que la relación exista sin duplicarse
                $commercial->typeService()->syncWithoutDetaching([$typeService->id]);
            } else {
                // Si es una creación, simplemente la agregamos
                $commercial->typeService()->attach($typeService->id);
            }
        }

        $freight->fill([
            'value_utility' => $request->value_utility,
            'accepted_answer_value' => $request->accepted_answer_value,
            'total_answer_utility' => $request->total_answer_utility,
            'value_sale' => $request->value_sale,
            'profit' => $request->profit,
            /* 'total_additional_points' => $request->total_additional_points,
            'total_additional_points_used' => $request->total_additional_points_used, */
            'state' => $request->state ?? 'Pendiente',
            'id_quote_freight' => $request->id_quote_freight,
            'nro_quote_commercial' => $request->nro_quote_commercial,
        ]);

        $freight->save();


        return $freight;
    }


    public function createOrUpdateInsurance(Request $request, Freight $freight)
    {

        if (!$request->state_insurance) {

            //Eliminamos el seguro vinculado al flete si existe.
            Insurance::where('id_insurable_service', $freight->id)
                ->where('model_insurable_service', Freight::class)->delete();

            return null; // Si no se envía el seguro, no se hace nada
        }


        /*   $sales_price = $this->parseDouble($request->value_insurance) + $this->parseDouble($request->insurance_added); */

        $insurance = Insurance::where('id_insurable_service', $freight->id)
            ->where('model_insurable_service', Freight::class)
            ->first();


        if ($insurance) {
            // Si el seguro existe, actualizarlo
            $insurance->update([
                'insurance_value' => $this->parseDouble($request->value_insurance),
                'insurance_sales_value' => $this->parseDouble($request->insurance_sales_value),
                'id_type_insurance' =>  $request->type_insurance,
                'state' => 'Pendiente',
            ]);
        } else {
            // Si no existe, crearlo
            $insurance = Insurance::create([
                'insurance_value' => $this->parseDouble($request->value_insurance),
                'insurance_sales_value' => $this->parseDouble($request->insurance_sales_value),
                'id_type_insurance' =>  $request->type_insurance,
                'name_service' => 'Flete',
                'id_insurable_service' => $freight->id,
                'model_insurable_service' => Freight::class,
                'state' => 'Pendiente'
            ]);

            $freight->insurance()->save($insurance);
        }


        return $insurance;
    }

    public function updateConceptInsurance($concepts, $freight, $request)
    {

        $arrayConcepts = (array) $concepts; //convertimos array los conceptos
        $lastKey = array_key_last($arrayConcepts); // obtenemos el ultimo indice
        $key = $lastKey + 1; // agregamos al ultimo indice par acrear el concepto de seguro


        $concept = Concept::where('name', 'SEGURO')
            ->where('id_type_shipment', $freight->commercial_quote->type_shipment->id)
            ->whereHas('typeService', function ($query) {
                $query->where('name', 'Flete');  // Segunda condición: Filtrar por name del tipo de servicio
            })
            ->first();

        // Crear o actualizar el objeto del seguro
        $insuranceObject = new stdClass();
        $insuranceObject->id = $concept->id;
        $insuranceObject->name = 'SEGURO';
        $insuranceObject->value = $request->insurance_sales_value;

        // Guardar el concepto actualizado en el array
        $concepts[$key] = $insuranceObject;

        return $concepts;
    }


    public function syncFreightConcepts($freight, $concepts)
    {
        // Eliminar los conceptos previos si estamos actualizando, pero antes 
        $conceptsFreight = ConceptFreight::where('id_freight', $freight->id)->get(); // cuando eliminamos el concepto se elimina el additional_point relacionado en cascada

        if ($conceptsFreight) {
            foreach ($conceptsFreight as $concept) {
                $concept->forceDelete(); // Esto elimina el ConceptFreight definitivamente
            }
        }

        // Relacionamos los nuevos conceptos con el flete
        foreach ($concepts as $concept) {
            $conceptFreight = ConceptFreight::create([
                'concepts_id' => $concept->id, // ID del concepto relacionado
                'id_freight' => $freight->id, // Clave foránea al modelo Freight
                'value_concept' => $this->parseDouble($concept->value),
              
            ]);
        }
    }


    public function parseDouble($num)
    {

        $valorDecimal = (float)str_replace(',', '', $num);

        return $valorDecimal;
    }
}
