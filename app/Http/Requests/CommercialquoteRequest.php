<?php

namespace App\Http\Requests;

use App\Models\Incoterms;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommercialquoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    protected function failedValidation(Validator $validator)
    {
        // Mostrar los mensajes de error en un dd()
        dd('❌ Errores de validación detectados:', $validator->errors()->toArray());

        // Si ya terminas de probar, elimina el dd() y descomenta esto:
        // throw new HttpResponseException(
        //     redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput()
        // );
    }

    protected function prepareForValidation()
    {
        // Helpers
        $jsonOrArray = fn($v) => is_string($v) ? json_decode($v, true) : (is_array($v) ? $v : null);
        $emptyToNull = fn($v) => $v === '' ? null : $v;

        $this->merge([
            // Arrays que a veces llegan como JSON string
            'type_service_checked'   => $jsonOrArray($this->type_service_checked),
            'shippers_consolidated'  => $jsonOrArray($this->shippers_consolidated),
            'shippers_fcl_consolidated'  => $jsonOrArray($this->shippers_fcl_consolidated),
            'data_containers'        => $jsonOrArray($this->data_containers),
            'data_containers_consolidated'        => $jsonOrArray($this->data_containers_consolidated),

            // Flags que llegan como "0"/"1"/"true"/"false"
            'is_consolidated'        => filter_var($this->is_consolidated, FILTER_VALIDATE_BOOLEAN),

            // Vacíos a null (para que required_with/without funcionen bien)
            'weight'                 => $emptyToNull($this->weight),
            'volumen_kgv'            => $emptyToNull($this->volumen_kgv),
            'pickup_address_at_origin' => $emptyToNull($this->pickup_address_at_origin),

            // Monetarios / numéricos con comas del frontend
            'load_value'             => $this->load_value ? str_replace(',', '', $this->load_value) : null,
            'pounds'                 => $this->pounds ? str_replace(',', '', $this->pounds) : null,

            // Unidades/strings vacíos -> null
            'unit_of_weight'         => $emptyToNull($this->unit_of_weight),
            'unit_of_volumen_kgv'    => $emptyToNull($this->unit_of_volumen_kgv),

            // Medidas como JSON string -> array (si tu regla las valida)
            'value_measures'         => is_string($this->value_measures)
                ? $this->value_measures // si decides guardarlo como string JSON
                : (is_array($this->value_measures) ? json_encode($this->value_measures) : null),

            // Nombre de modo más estable (por si llega mal tipeado)
            'type_shipment_name'     => $emptyToNull($this->type_shipment_name),
        ]);


        if (blank($this->weight)) {
            $this->merge(['unit_of_weight' => null]);
        }

        // Si no hay volumen, borro la unidad
        if (blank($this->volumen_kgv)) {
            $this->merge(['unit_of_volumen_kgv' => null]);
        }
    }

    public function onlyTransport(): bool
    {
        $raw = $this->input('type_service_checked');
        $arr = is_array($raw) ? $raw : json_decode($raw ?? '[]', true);
        return is_array($arr) && count($arr) === 1 && strtolower($arr[0]) === 'transporte';
    }


    public function isExw(): bool
    {
        $id = $this->input('id_incoterms');
        if (!$id) return false;

        $incoterm = Incoterms::find($id);
        return $incoterm && strtolower($incoterm->code) === 'exw';
    }


    public function rules(): array
    {
        /* dd($this->all()); */
        // Reglas base (aplican para ambos casos)
        $base = [
            'id_type_shipment'   => ['required'],
            'id_type_load'       => ['required'],
            'commodity'          => ['exclude_if:is_consolidated,true', 'exclude_if:lcl_fcl,FCL', 'required'],

            // (peso & volumen) O medidas
            'weight'             => [
                'exclude_if:is_consolidated,true',
                'exclude_if:lcl_fcl,FCL',
                'nullable',
                'numeric',
                'required_without:value_measures',
                Rule::when(fn($input) => empty($input['value_measures']), ['required_with:volumen_kgv'])
            ],
            'unit_of_weight'     => ['nullable', 'required_with:weight'],

            'volumen_kgv'        => [
                'exclude_if:is_consolidated,true',
                'exclude_if:lcl_fcl,FCL',
                'nullable',
                'numeric',
                'required_without:value_measures',
                Rule::when(fn($input) => empty($input['value_measures']), ['required_with:weight'])
            ],
            'unit_of_volumen_kgv' => ['nullable', 'required_with:volumen_kgv'],
            'load_value'          => ['exclude_if:is_consolidated,true', 'exclude_if:lcl_fcl,FCL', 'required'],

            'value_measures'     => ['exclude_if:is_consolidated,true', 'exclude_if:lcl_fcl,FCL', 'nullable', 'string', 'min:1', 'required_without_all:weight,volumen_kgv'],
            'type_shipment_name' => ['required'],
            'lcl_fcl'            => ['required_if:type_shipment_name,Marítima'],
            'observation'        => ['nullable'],
            'nro_package'       => ['exclude_if:is_consolidated,true', 'exclude_if:lcl_fcl,FCL', 'required', 'integer'],
            'id_packaging_type' => ['exclude_if:is_consolidated,true', 'exclude_if:lcl_fcl,FCL', 'required', 'integer'],
            'type_service_checked'    => ['nullable', 'array'],

            'shippers_consolidated' => ['nullable', 'array', function ($attribute, $value, $fail) {
                if ($this->is_consolidated === true && $this->lcl_fcl === 'LCL' && empty($value)) {
                    $fail($attribute . ' es requerido cuando ambos valores son true.');
                }
            }],
            'data_containers'         => ['array', 'nullable', function ($attribute, $value, $fail) {
                if ($this->is_consolidated === false && $this->lcl_fcl === 'FCL' && empty($value)) {
                    $fail($attribute . ' es requerido cuando ambos valores son true.');
                }
            }],

            'shippers_fcl_consolidated' => ['array', 'nullable', function ($attribute, $value, $fail) {
                if ($this->is_consolidated === true && $this->lcl_fcl === 'FCL' && empty($value)) {
                    $fail($attribute . ' es requerido cuando ambos valores son true.');
                }
            }],
            'data_containers_consolidated'         => ['array', 'nullable', function ($attribute, $value, $fail) {
                if ($this->is_consolidated === true && $this->lcl_fcl === 'FCL' && empty($value)) {
                    $fail($attribute . ' es requerido cuando ambos valores son true.');
                }
            }],

            'is_customer_prospect'    => ['required', 'in:prospect,customer'],
            'customer_company_name'   => ['required_if:is_customer_prospect,prospect', 'nullable', 'string', 'min:2'],
            'id_customer'             => ['required_if:is_customer_prospect,customer', 'nullable', 'integer'],
        ];

        // Extra si NO es solo transporte
        $full = [
            'origin'              => ['required', 'string'],
            'destination'         => ['required', 'string'],
            'id_regime'           => ['required'],
            'id_incoterms'        => ['required', 'integer'],
            'id_customs_district' => ['required', 'integer'],
            'is_consolidated' => ['required', 'boolean'],
            'pickup_address_at_origin' => $this->isExw()
                ? ['exclude_if:is_consolidated,true', 'exclude_if:lcl_fcl,FCL', 'required', 'string', 'min:5']
                : ['nullable'],
        ];

        return $this->onlyTransport()
            ? $base
            : array_merge($base, $full);
    }

    public function messages(): array
    {
        return [
            'weight.required_without'              => 'Debe proporcionar Peso y Volumen, o Medidas.',
            'volumen_kgv.required_without'         => 'Debe proporcionar Peso y Volumen, o Medidas.',
            'value_measures.required_without_all'  => 'Debe proporcionar Peso y Volumen, o Medidas.',
            'weight.required_with'                 => 'Si indica Volumen, también debe indicar Peso.',
            'volumen_kgv.required_with'           => 'Si indica Peso, también debe indicar Volumen.',
            'unit_of_weight.required_with'         => 'Indique la unidad del Peso.',
            'unit_of_volumen_kgv.required_with'    => 'Indique la unidad del Volumen.',
            'pickup_address_at_origin.required'    => 'Para INCOTERM EXW, la dirección de recojo es obligatoria.',
            'is_customer_prospect.required' => 'Debe indicar si el cliente es prospecto o existente.',
            'is_customer_prospect.in'       => 'El tipo de cliente debe ser "prospect" o "customer".',
            'customer_company_name.required_if' => 'Debe ingresar el nombre o razón social del cliente.',
            'id_customer.required_if'           => 'Debe seleccionar un cliente existente.',
        ];
    }
}
