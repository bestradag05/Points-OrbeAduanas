<div class="row mt-3">
    <div class="col-6">

        <h5 class="text-indigo mb-2 text-center py-3">
            <i class="fa-regular fa-circle-info"></i>
            Información de la operacion
        </h5>

        <div class="row">

            <div class="col-12 border-bottom border-bottom-2">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Fecha de validez: </label>
                    <div class="col-sm-6">

                        @php
                            $config = [
                                'format' => 'DD/MM/YYYY',
                                'minDate' => now()->format('Y-m-d'),
                                'language' => 'es', // Configurar en español
                            ];

                            $currentDate = \Carbon\Carbon::parse($comercialQuote->valid_date)->format('d/m/Y'); // Formato compatible con el picker
                        @endphp

                        @if ($comercialQuote->state === 'Pendiente')
                            <form action={{ url('/commercial/quote/updatedate/' . $comercialQuote->id) }} method="POST"
                                class="row align-items-center" enctype="multipart/form-data">
                                {{ method_field('PATCH') }}
                                {{ csrf_field() }}


                                <div class="col-8">
                                    <x-adminlte-input-date id="valid_date" name="valid_date" value="{{ $currentDate }}"
                                        :config="$config" placeholder="Selecciona la fecha de validez..." />
                                </div>

                                <div class="col-2">
                                    <button type="submit" class="btn"><i
                                            class="fas fa-sync mb-3 text-indigo"></i></button>
                                </div>
                            </form>
                        @else
                            <p id="valid_date" class="form-control-plaintext text-indigo d-inline">
                                {{ $currentDate }}</p>
                        @endif



                    </div>

                </div>

            </div>

            <div class="col-12 border-bottom border-bottom-2">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nro Cotización: </label>
                    <div class="col-sm-8 d-inline">
                        <p id="nro_quote_commercial" class="form-control-plaintext text-indigo d-inline">
                            {{ $comercialQuote->nro_quote_commercial }}</p>
                        {{--  <a href="{{ url('/commercial/quote/getPDF/' . $comercialQuote->id) }}"
                            class="text-indigo d-inline">
                            <i class="fas fa-file-pdf"></i>
                        </a> --}}
                        <a href="{{ url('commercial/quote/getPDF/' . $comercialQuote->id) }}" target="_blank"
                            class=" text-indigo d-inline">
                            <i class="fas fa-file-pdf"></i>
                        </a>

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

                @foreach ($comercialQuote->consolidatedCargos as $consolidated)
                    @php
                        $shipper = json_decode($consolidated->supplier_temp);
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
                                        {{ $shipper->shipper_name }}
                                        <i class="fas fa-sort-down mx-3"></i>
                                    </button>
                                </h2>
                            </div>

                            <div id="collapse{{ $consolidated->id }}" class="collapse"
                                data-parent="#accordionConsolidated">

                                <div class="row text-muted px-5">
                                    <div class="col-12  {{ $shipper->shipper_name ? '' : 'd-none' }}">
                                        <p class="text-sm">Proovedor :
                                            <b class="d-block">{{ $shipper->shipper_name }}</b>
                                        </p>
                                    </div>

                                    <div class="col-4">
                                        <p class="text-sm">Contacto :
                                            <b class="d-block">{{ $shipper->shipper_contact }}</b>
                                        </p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-sm">Email :
                                            <b class="d-block">{{ $shipper->shipper_contact_email }}</b>
                                        </p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-sm">Telefono :
                                            <b class="d-block">{{ $shipper->shipper_contact_phone }}</b>
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-sm">Direccion :
                                            <b class="d-block">{{ $shipper->shipper_address }}</b>
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
                                    <div class="col-6">
                                        <p class="text-sm">Volumen :
                                            <b class="d-block">{{ $consolidated->volumen }}</b>
                                        </p>
                                    </div>
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

                                    <p class="form-control-plaintext">{{ $comercialQuote->container_type }}</p>
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
            Servicios
        </h5>

        <select name="type_service" id="type_service" class="form-control" onchange="openModalForm(this)">
            <option></option>
            @foreach ($type_services as $type_service)
                @php
                    $disabled = false;
                    foreach ($services as $index => $service) {
                        if ($type_service->name == $index) {
                            $disabled = true;
                            break;
                        }
                    }
                @endphp
                <option value="{{ $type_service->id }}" {{ $disabled ? 'disabled' : '' }}>
                    {{ $type_service->name }}
                </option>
            @endforeach
        </select>


        <hr>
        {{-- <p class="text-indigo text-bold">Lista de Servicios: </p> --}}
        <table class="table text-center">
            <thead>
                <th class="text-indigo text-bold">Servicios</th>
                <th class="text-indigo text-bold">Seguro</th>
                <th class="text-indigo text-bold">Estado</th>
                <th class="text-indigo text-bold">Acciones</th>
            </thead>
            <tbody>

                @foreach ($services as $index => $service)
                    <tr>
                        <td>
                            <a class="btn btn-indigo w-100">
                                {{ $index }}
                            </a>
                        </td>

                        <td class="text-bold  {{ $service->insurance ? 'text-success' : 'text-danger' }}">

                            @if ($service->insurance)
                                Tiene seguro
                            @else
                                @if ($index != 'Transporte')
                                    Sin seguro
                                @else
                                    -
                                @endif
                            @endif
                        </td>
                        <td class="text-bold  status-{{ strtolower($service->state) }}">
                            {{ $service->state }}
                        </td>


                        @if ($comercialQuote->state === 'Pendiente')
                            <td>
                                <a href="{{ url('/commercial/service/' . strtolower($index) . '/' . $service->id) }}"
                                    class="text-indigo"><i class="fas fa-edit"></i></a>
                            </td>
                        @endif
                    </tr>
                @endforeach

            </tbody>
        </table>

        <div class="row justify-content-center text-bold mt-5">
            <div class="col-6">
                <p class="text-uppercase ">Estado :
                    <b class="status-{{ strtolower($comercialQuote->state) }}">{{ $comercialQuote->state }}</b>
                    <b class="status-{{ strtolower($comercialQuote->state) }}"><i class="fas fa-circle"></i></b>

                </p>
            </div>

        </div>

    </div>

    @if ($comercialQuote->typeService->count() > 0)
        @if ($comercialQuote->state === 'Pendiente')
            <div class="col-12">
                <div class="row justify-content-center mt-5">
                    <button class="btn btn-indigo mx-2 text-bold"
                        onclick="handleActionCommercialQuote('accept', '{{ $comercialQuote->id }}')">ACEPTAR <i
                            class="fas fa-check"></i></button>
                    <button class="btn btn-secondary mx-2 text-bold"
                        onclick="handleActionCommercialQuote('decline', '{{ $comercialQuote->id }}')">RECHAZAR <i
                            class="fas fa-times"></i></button>
                </div>
            </div>
        @endif

    @endif


</div>


{{-- Modales de los servicios --}}


@include('commercial_quote/modals/modalFreight')
@include('commercial_quote/modals/modalCustom')
@include('commercial_quote/modals/modalTransport')

@push('scripts')
    <script>
        $('#type_service').select2({
            width: 'resolve',
            placeholder: "Seleccione una opcion...",
            allowClear: true
        });

        let TotalConcepts = 0;
        let total = 0;
        let flete = 0;
        let containerResult = '';
        let container = '';
        let typeService = '';

        function openModalForm(element) {
            let selected = element.options[element.selectedIndex].text;
            containerResult = $(`#modal${selected}`).modal('show');
            container = containerResult[0];
            typeService = element.value;
            $(`#${container.id}`).find('#typeService').val(typeService);
            element.value = '';

        }



        function handleActionCommercialQuote(action, id) {

            let textAction = (action === 'accept') ? 'aceptar' : 'rechazar';

            Swal.fire({
                title: `¿Estas seguro que deseas ${textAction} esta cotización?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#2e37a4",
                cancelButtonColor: "#6c757d",
                confirmButtonText: `Si, ${textAction}!`,
                cancelButtonText: 'No, cancelar',
                allowOutsideClick: false // Evita que se cierre al hacer clic fuera
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Listo!",
                        text: `tu cotizacion se acaba de ${textAction} .`,
                        icon: "success",
                        allowOutsideClick: false
                    }).then((result) => {
                        window.location.href = `/commercial/quote/state/${action}/${id}`;
                    })
                }
            });

        }


        // Mostrar mensaje de error
        function showError(input, message) {
            let errorSpan = input.nextElementSibling;
            if (!errorSpan || !errorSpan.classList.contains('invalid-feedback')) {
                errorSpan = document.createElement('span');
                errorSpan.classList.add('invalid-feedback');
                input.after(errorSpan);
            }
            errorSpan.textContent = message;
            errorSpan.style.display = 'block';
        }


        // Ocultar mensaje de error
        function hideError(input) {
            let errorSpan = input.nextElementSibling;
            if (errorSpan && errorSpan.classList.contains('invalid-feedback')) {
                errorSpan.style.display = 'none';
            }
        }




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
