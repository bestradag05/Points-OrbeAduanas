@extends('home')

@section('dinamic-content')

    <div class="row mt-3 px-3">

        <div class="col-12 text-right">
            <a href="{{ url('/quote/freight') }}" class="btn btn-primary"> <i class="fas fa-arrow-left"></i> Atras </a>
        </div>

        <div class="col-6">

            <h5 class="text-indigo mb-2 text-center py-3">
                <i class="fa-regular fa-circle-info"></i>
                Información de la operacion
            </h5>

            <div class="row">
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Cliente : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->customer->name_businessname }}</p>
                        </div>

                    </div>
                </div>

                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Origen : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->origin }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Destino : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->destination }}</p>
                        </div>

                    </div>
                </div>
                <div
                    class="col-12 border-bottom border-bottom-2 {{ $comercialQuote->customer_company_name ? '' : 'd-none' }}">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Cliente : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->customer_company_name }}</p>
                        </div>

                    </div>
                </div>
                @if ($comercialQuote->is_consolidated)
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Carga Consolidada : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">SI</p>
                            </div>

                        </div>
                    </div>
                    @if ($comercialQuote->type_shipment->description === 'Marítima')

                        @if ($comercialQuote->lcl_fcl === 'FCL')
                            <div class="col-12 border-bottom border-bottom-2">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Contenedor : </label>
                                    <div class="col-sm-8">

                                        <p class="form-control-plaintext">
                                            {{ $comercialQuote->container_quantity }}x{{ $comercialQuote->container->name }}
                                        </p>
                                    </div>

                                </div>
                            </div>
                        @endif
                    @endif

                    @foreach ($comercialQuote->consolidatedCargos as $consolidated)
                        @php
                            $shipperTemp = json_decode($consolidated->supplier_temp);
                            $shipper = null;
                            if (!$shipper) {
                                $shipper = $consolidated->supplier;
                            }
                            $measures = json_decode($consolidated->value_measures);
                        @endphp


                        <div class="col-12 border-bottom border-bottom-2">
                            <div class="accordion" id="accordionConsolidated">
                                <div>
                                    <h2 class="mb-0">
                                        <button
                                            class="btn btn-link btn-block px-0 text-dark text-semibold text-left d-flex align-items-center"
                                            type="button" data-toggle="collapse"
                                            data-target="#collapse{{ $consolidated->id }}" aria-expanded="true">
                                            <span class="text-indigo text-bold">Shipper {{ $loop->iteration }}</span>:
                                            {{ isset($shipperTemp->shipper_name) ? $shipperTemp->shipper_name : $shipper->name_businessname }}
                                            <i class="fas fa-sort-down mx-3"></i>
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapse{{ $consolidated->id }}" class="collapse"
                                    data-parent="#accordionConsolidated">

                                    <div class="row text-muted px-5">
                                        <div class="col-12  {{ isset($shipperTemp->shipper_name) ? '' : 'd-none' }}">
                                            <p class="text-sm">Proovedor :
                                                <b
                                                    class="d-block">{{ isset($shipperTemp->shipper_name) ? $shipperTemp->shipper_name : $shipper->name_businessname }}</b>
                                            </p>
                                        </div>

                                        <div class="col-4">
                                            <p class="text-sm">Contacto :
                                                <b
                                                    class="d-block">{{ isset($shipperTemp->shipper_contact) ? $shipperTemp->shipper_contact : $shipper->contact_name }}</b>
                                            </p>
                                        </div>
                                        <div class="col-4">
                                            <p class="text-sm">Email :
                                                <b
                                                    class="d-block">{{ isset($shipperTemp->shipper_contact_email) ? $shipperTemp->shipper_contact_email : $shipper->contact_email }}</b>
                                            </p>
                                        </div>
                                        <div class="col-4">
                                            <p class="text-sm">Telefono :
                                                <b
                                                    class="d-block">{{ isset($shipperTemp->shipper_contact_phone) ? $shipperTemp->shipper_contact_phone : $shipper->contact_number }}</b>
                                            </p>
                                        </div>
                                        <div class="col-12">
                                            <p class="text-sm">Direccion :
                                                <b
                                                    class="d-block">{{ isset($shipperTemp->shipper_address) ? $shipperTemp->shipper_address : $shipper->address }}</b>
                                            </p>
                                        </div>
                                        <div class="col-12">
                                            <p class="text-sm">Descripcion de carga :
                                                <b class="d-block">{{ $consolidated->commodity }}</b>
                                            </p>
                                        </div>
                                        <div class="col-12">
                                            <p class="text-sm">Valor del producto :
                                                <b class="d-block">{{ $consolidated->load_value }}</b>
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm">N° de Bultos :
                                                <b class="d-block">{{ $consolidated->nro_packages }}</b>
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm">Tipo de embalaje :
                                                <b class="d-block">{{ $consolidated->packaging_type }}</b>
                                            </p>
                                        </div>
                                        @if ($consolidated->commercialQuote->type_shipment->description === 'Marítima')
                                            <div class="col-6">
                                                <p class="text-sm">Volumen :
                                                    <b class="d-block">{{ $consolidated->volumen }} CBM</b>
                                                </p>
                                            </div>
                                        @else
                                            <div class="col-6">
                                                <p class="text-sm">KGV :
                                                    <b class="d-block">{{ $consolidated->kilogram_volumen }} KGV</b>
                                                </p>
                                            </div>
                                        @endif
                                        <div class="col-6">
                                            <p class="text-sm">Peso :
                                                <b class="d-block">{{ $consolidated->kilograms }}</b>
                                            </p>
                                        </div>
                                        @if ($measures)
                                            <table class="table table-striped">
                                                <thead>
                                                    <th>Cantidad</th>
                                                    <th>Ancho</th>
                                                    <th>Largo</th>
                                                    <th>Alto</th>
                                                    <th>Unidad</th>
                                                </thead>
                                                <tbody>
                                                    @foreach ($measures as $measure)
                                                        <tr>
                                                            <td>{{ $measure->amount }}</td>
                                                            <td>{{ $measure->width }}</td>
                                                            <td>{{ $measure->length }}</td>
                                                            <td>{{ $measure->height }}</td>
                                                            <td>{{ $measure->unit_measurement }}</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Producto / Mercancía : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">{{ $comercialQuote->commodity }}</p>
                            </div>

                        </div>
                    </div>

                    @if ($comercialQuote->type_shipment->description === 'Aérea')
                        <div class="col-12 border-bottom border-bottom-2">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Peso KG : </label>
                                <div class="col-sm-8">

                                    <p class="form-control-plaintext">{{ $comercialQuote->kilograms }}</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 border-bottom border-bottom-2">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">KGV : </label>
                                <div class="col-sm-8">

                                    <p class="form-control-plaintext">{{ $comercialQuote->kilogram_volumen }}</p>
                                </div>

                            </div>
                        </div>
                    @endif

                    @if ($comercialQuote->type_shipment->description === 'Marítima')
                        @if ($comercialQuote->lcl_fcl === 'FCL')
                            <div class="col-12 border-bottom border-bottom-2">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Contenedor : </label>
                                    <div class="col-sm-8">

                                        <p class="form-control-plaintext">
                                            {{ $comercialQuote->container_quantity }}x{{ $comercialQuote->container->name }}
                                        </p>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 border-bottom border-bottom-2">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Toneladas : </label>
                                    <div class="col-sm-8">

                                        <p class="form-control-plaintext">{{ $comercialQuote->tons }}</p>
                                    </div>

                                </div>
                            </div>
                        @else
                            <div class="col-12 border-bottom border-bottom-2">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Peso : </label>
                                    <div class="col-sm-8">

                                        <p class="form-control-plaintext">{{ $comercialQuote->kilograms }}</p>
                                    </div>

                                </div>
                            </div>
                        @endif
                        <div class="col-12 border-bottom border-bottom-2">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Volumen : </label>
                                <div class="col-sm-8">

                                    <p class="form-control-plaintext">{{ $comercialQuote->volumen }}</p>
                                </div>

                            </div>
                        </div>

                    @endif



                @endif


                <div class="col-12" id="extraFieldsOpen">
                    <a class="btn btn-link btn-block text-center" data-bs-toggle="collapse" data-bs-target="#extraFields"
                        onclick="toggleArrows(true)">
                        <i class="fas fa-sort-down " id="arrowDown"></i>
                    </a>
                </div>

                <div class="col-12 row collapse mt-2" id="extraFields">

                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Incoterm : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">{{ $comercialQuote->incoterm->code }}</p>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Tipo de carga : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">{{ $comercialQuote->type_load->name }}</p>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Valor de la Carga : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">$ {{ $comercialQuote->load_value }}</p>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Tipo de embarque : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">
                                    {{ $comercialQuote->type_shipment->description . ($comercialQuote->type_shipment->description === 'Marítima' && $comercialQuote->lcl_fcl ? ' (' . $comercialQuote->lcl_fcl . ')' : '') }}

                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Régimen : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">{{ $comercialQuote->regime->description }}</p>
                            </div>

                        </div>
                    </div>

                    <div class="col-12 text-center mt-3">
                        <a class="btn btn-link text-center" data-bs-toggle="collapse" data-bs-target="#extraFields"
                            onclick="toggleArrows(false)">
                            <i class="fas fa-sort-up" id="arrowUp"></i>
                        </a>
                    </div>


                </div>
            </div>

        </div>

        <div class="col-6 px-5">

            <h5 class="text-indigo mb-2 text-center py-3">
                <i class="fa-duotone fa-gear"></i>
                Documentos
            </h5>
    
         
            <table class="table text-center">
                <thead>
                    <th class="text-indigo text-bold">Nombre</th>
                    <th class="text-indigo text-bold">Acciones</th>
                </thead>
                <tbody>
    
           
    
                </tbody>
            </table>
    
           
    
        </div>

    </div>
@stop

@push('scripts')
    <script>
     
        function toggleArrows(isOpening) {
            var arrowDown = document.getElementById('arrowDown');
            var arrowUp = document.getElementById('arrowUp');

            if (isOpening) {
                arrowDown.style.display = 'none';
                arrowUp.style.display = 'inline';
            } else {
                arrowDown.style.display = 'inline';
                arrowUp.style.display = 'none';
            }
        }

        document.getElementById('extraFields').addEventListener('show.bs.collapse', function() {
            toggleArrows(true);
        });

        document.getElementById('extraFields').addEventListener('hide.bs.collapse', function() {
            toggleArrows(false);
        });
    </script>
@endpush
