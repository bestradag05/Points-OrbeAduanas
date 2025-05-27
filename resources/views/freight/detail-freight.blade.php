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

                            <p class="form-control-plaintext">{{ $commercialQuote->customer->name_businessname }}</p>
                        </div>

                    </div>
                </div>

                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Origen : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $commercialQuote->origin }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Destino : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $commercialQuote->destination }}</p>
                        </div>

                    </div>
                </div>
                <div
                    class="col-12 border-bottom border-bottom-2 {{ $commercialQuote->customer_company_name ? '' : 'd-none' }}">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Cliente : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $commercialQuote->customer_company_name }}</p>
                        </div>

                    </div>
                </div>
                @if ($commercialQuote->is_consolidated)
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Carga Consolidada : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">SI</p>
                            </div>

                        </div>
                    </div>
                    @if ($commercialQuote->type_shipment->description === 'Marítima')

                        @if ($commercialQuote->lcl_fcl === 'FCL')
                            <div class="col-12 border-bottom border-bottom-2">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Contenedor : </label>
                                    <div class="col-sm-8">

                                        <p class="form-control-plaintext">
                                            {{ $commercialQuote->container_quantity }}x{{ $commercialQuote->container->name }}
                                        </p>
                                    </div>

                                </div>
                            </div>
                        @endif
                    @endif

                    @foreach ($commercialQuote->consolidatedCargos as $consolidated)
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

                                <p class="form-control-plaintext">{{ $commercialQuote->commodity }}</p>
                            </div>

                        </div>
                    </div>

                    @if ($commercialQuote->type_shipment->description === 'Aérea')
                        <div class="col-12 border-bottom border-bottom-2">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Peso KG : </label>
                                <div class="col-sm-8">

                                    <p class="form-control-plaintext">{{ $commercialQuote->kilograms }}</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 border-bottom border-bottom-2">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">KGV : </label>
                                <div class="col-sm-8">

                                    <p class="form-control-plaintext">{{ $commercialQuote->kilogram_volumen }}</p>
                                </div>

                            </div>
                        </div>
                    @endif

                    @if ($commercialQuote->type_shipment->description === 'Marítima')
                        @if ($commercialQuote->lcl_fcl === 'FCL')
                            <div class="col-12 border-bottom border-bottom-2">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Contenedor : </label>
                                    <div class="col-sm-8">

                                        <p class="form-control-plaintext">
                                            {{ $commercialQuote->container_quantity }}x{{ $commercialQuote->container->name }}
                                        </p>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 border-bottom border-bottom-2">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Toneladas : </label>
                                    <div class="col-sm-8">

                                        <p class="form-control-plaintext">{{ $commercialQuote->tons }}</p>
                                    </div>

                                </div>
                            </div>
                        @else
                            <div class="col-12 border-bottom border-bottom-2">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Peso : </label>
                                    <div class="col-sm-8">

                                        <p class="form-control-plaintext">{{ $commercialQuote->kilograms }}</p>
                                    </div>

                                </div>
                            </div>
                        @endif
                        <div class="col-12 border-bottom border-bottom-2">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Volumen : </label>
                                <div class="col-sm-8">

                                    <p class="form-control-plaintext">{{ $commercialQuote->volumen }}</p>
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

                                <p class="form-control-plaintext">{{ $commercialQuote->incoterm->code }}</p>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Tipo de carga : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">{{ $commercialQuote->type_load->name }}</p>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Valor de la Carga : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">$ {{ $commercialQuote->load_value }}</p>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Tipo de embarque : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">
                                    {{ $commercialQuote->type_shipment->description . ($commercialQuote->type_shipment->description === 'Marítima' && $commercialQuote->lcl_fcl ? ' (' . $commercialQuote->lcl_fcl . ')' : '') }}

                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Régimen : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">{{ $commercialQuote->regime->description }}</p>
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

            <div class="row justify-content-center py-3">
                <h5 class="text-indigo m-0">
                    Documentos
                </h5>
                <button type="button" class="btn btn-indigo btn-sm mx-2 " onclick="showModalUpdateDocumentFreight()"><i
                        class="fas fa-plus"></i></button>
            </div>

            @php
                $requiredDocuments = ['Routing Order', 'Factura Comercial', 'BL Draf'];

                if ($freight->state != 'Pendiente') {
                    $requiredDocuments[] = 'BL Final';
                }

                $uploadedDocuments = $freight->documents->keyBy(fn($doc) => strtolower(trim($doc->name)));
                $blFinalUploaded = $uploadedDocuments->has('bl final');
                $allRequiredUploaded = collect($requiredDocuments)->every(function ($doc) use ($uploadedDocuments) {
                    return $uploadedDocuments->has(strtolower(trim($doc)));
                });
            @endphp

            <table class="table mt-2">
                <thead>
                    <tr>
                        <th class="text-indigo text-bold">Nombre</th>
                        <th class="text-indigo text-bold ">Documento</th>
                        <th class="text-indigo text-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Documentos obligatorios --}}
                    @foreach ($requiredDocuments as $required)
                        @php
                            $docKey = strtolower(trim($required));
                            $document = $uploadedDocuments[$docKey] ?? null;
                        @endphp
                        <tr>
                            <td class="text-indigo text-uppercase text-bold">{{ $required }} <span
                                    class="text-danger">*</span>
                            </td>
                            <td class="text-center">
                                @if ($document)
                                    <a href="{{ asset($document->path) }}" target="_blank" class="btn text-danger">
                                        <x-file-icon :path="$document->path" />
                                    </a>
                                @elseif($required === 'Routing Order')
                                    {{-- No mostrar botón de subida para Routing Order --}}
                                    <span class="text-muted">Aún no generado</span>
                                @else
                                    <form action="{{ url('/freight/upload_file/' . $freight->id) }}" method="POST"
                                        enctype="multipart/form-data" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="name_file" value="{{ $required }}">
                                        <input type="file" name="file" required onchange="this.form.submit()"
                                            style="display: none;" id="fileInput_{{ $loop->index }}">
                                        <button type="button" class="btn btn-sm text-primary" title="Subir archivo"
                                            onclick="uploadRequiredFile({{ $loop->index }})">
                                            <i class="fas fa-upload"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>

                            @if ($document && $freight->state === 'Pendiente')
                                <td>
                                    <form action="{{ url('/freight/delete_file/' . $document->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn text-danger">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </td>
                            @else
                                <td></td>
                            @endif

                        </tr>
                    @endforeach

                    {{-- Documentos no obligatorios --}}
                    @foreach ($freight->documents as $document)
                        @php
                            $docName = strtolower(trim($document->name));
                        @endphp
                        @if (!in_array($docName, collect($requiredDocuments)->map(fn($d) => strtolower($d))->toArray()))
                            <tr>
                                <td class="text-indigo text-uppercase">{{ $document->name }}</td>
                                <td class="text-center">
                                    <a href="{{ asset($document->path) }}" target="_blank" class="btn text-danger">
                                        <x-file-icon :path="$document->path" />
                                    </a>
                                </td>
                                @if ($freight->state === 'Pendiente')
                                    <td>
                                        <form action="{{ url('/freight/delete_file/' . $document->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn text-danger">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>


            <div class="row justify-content-center mt-4">

                <div class="col-12 mb-3 text-center">
                    <h6 class="custom-badge status-{{ Str::slug($freight->state) }}"> <i class="fas fa-circle"></i>
                        {{ $freight->state }}</h6>
                </div>


                @if ($lastNotification)
                    <div class="alert alert-danger text-sm">
                        <strong>Motivo:</strong> {{ $lastNotification->data['message'] }} <br>
                        <small class="text-warning">{{ $lastNotification->created_at->diffForHumans() }}</small>
                    </div>
                @endif


                @if (!$freight->documents->contains('name', 'Routing Order'))
                    <div class="col-6 col-xl-6">
                        <button class="btn btn-secondary btn-sm w-100" onclick="openModalgenerateRoutingOrder()">
                            Generar Routing
                        </button>
                    </div>
                @endif


                @if ($freight->state != 'En Proceso')
                    <div class="col-6 col-xl-6">
                        <form action="{{ url('/freight/send-operation/' . $freight->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('PUT') <!-- O POST, según tu ruta -->
                            <button class="btn btn-indigo btn-sm w-100" {{ $allRequiredUploaded ? '' : 'disabled' }}>
                                Enviar
                            </button>
                        </form>
                    </div>
                @elseif($freight->state === 'En Proceso')
                    <div class="col-6 col-xl-6">
                        <button class="btn btn-info btn-sm w-100" onclick="openModalNotification()" {{$blFinalUploaded ? '' : 'disabled'}}>
                            <i class="fas fa-info-circle"></i> Solicitar Correcion
                        </button>
                    </div>
                @endif



            </div>



        </div>

    </div>


    <x-adminlte-modal id="modalUploadDocumentFreight" class="modal" title="Documento necesarios para el proceso"
        size='lg' scrollable>
        <form action="{{ url('/freight/upload_file/' . $freight->id) }}" id="formUploadFile" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="customs_perception">Nombre</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="name_file"
                                placeholder="Ingrese el nombre del archivo" value="">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="customs_perception">Archivo: </label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="file" placeholder="Ingrese el archivo"
                                value="">
                        </div>
                    </div>
                </div>

            </div>

            <x-slot name="footerSlot">
                <x-adminlte-button class="btn btn-indigo" id="btnSubmit" type="submit" onclick="submitUploadFile(this)"
                    label="Guardar Archivo" />
                <x-adminlte-button theme="secondary" label="Cerrar" data-dismiss="modal" />
            </x-slot>

        </form>
    </x-adminlte-modal>


    {{-- Commercial Fill Data --}}
    <x-adminlte-modal id="generateRoutingOrder" class="modal" title="Complete la informacion para generar el routing"
        size='lg' scrollable>
        <form action="/freight/routing" method="POST" id="formgenerateRoutingOrder">
            @csrf

            <input type="hidden" name="id_freight" value="{{ $freight->id }}">

            <div class="row">

                <div class="col-12 ">
                    <div class="form-group">
                        <label for="wr_loading">WR Loading</label>

                        <textarea class="form-control" id="wr_loading" name="wr_loading" placeholder="Ingrese el numero de seguimiento"></textarea>

                    </div>

                </div>

            </div>

            <x-slot name="footerSlot">
                <x-adminlte-button class="btn btn-indigo" type="submit" onclick="submitGenerateRoutingOrder(this)"
                    label="Generar" />
                <x-adminlte-button theme="secondary" label="Cerrar" data-dismiss="modal" />
            </x-slot>

        </form>
    </x-adminlte-modal>

    {{-- Notification --}}
    <x-adminlte-modal id="generateNotification" class="modal" title="Envie notificación al asesor comercial"
        size='lg' scrollable>
        <form action="/freight/notify" method="POST" id="formGenerateNotification">
            @csrf
            <input type="hidden" name="id_freight" value="{{ $freight->id }}">
            <div class="row">

                <div class="col-12 ">
                    <div class="form-group">
                        <label for="message_freight">Mensaje</label>
                        <textarea class="form-control" id="message_freight" name="message_freight" placeholder="Ingrese mensaje"></textarea>
                    </div>
                </div>
            </div>

            <x-slot name="footerSlot">
                <x-adminlte-button class="btn btn-indigo" type="submit" onclick="submitGenerateNotification(this)"
                    label="Enviar" />
                <x-adminlte-button theme="secondary" label="Cerrar" data-dismiss="modal" />
            </x-slot>

        </form>
    </x-adminlte-modal>




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


        function showModalUpdateDocumentFreight() {
            $('#modalUploadDocumentFreight').modal('show');
        }

        function submitUploadFile() {

            let formUploadFile = $('#formUploadFile');
            let inputs = formUploadFile.find('input');

            let isValid = true;

            inputs.each(function() {
                let $input = $(this); // Convertir a objeto jQuery
                let value = $input.val();

                if (value.trim() === '') {
                    $input.addClass('is-invalid');
                    isValid = false;
                    showError(this, 'Debe completar este campo');
                } else {
                    $input.removeClass('is-invalid');
                    hideError(this);
                }
            });

            if (isValid) {
                formUploadFile.submit();
            }
        }

        function uploadRequiredFile(index) {
            document.getElementById(`fileInput_${index}`).click()
        }


        function openModalgenerateRoutingOrder() {
            $('#generateRoutingOrder').modal('show');

        }

        function openModalNotification() {
            $('#generateNotification').modal('show');

        }


        function submitGenerateRoutingOrder() {
            let formGenerateRoutingOrder = $('#formgenerateRoutingOrder');
            let inputs = formGenerateRoutingOrder.find('textarea');

            let isValid = true;

            inputs.each(function() {
                let $input = $(this); // Convertir a objeto jQuery
                let value = $input.val();

                if (value.trim() === '') {
                    $input.addClass('is-invalid');
                    isValid = false;
                    showError(this, 'Debe completar este campo');
                } else {
                    $input.removeClass('is-invalid');
                    hideError(this);
                }
            });

            if (isValid) {
                formGenerateRoutingOrder.submit();
            }
        }

        function submitGenerateNotification() {
            let formGenerateNotification = $('#formGenerateNotification');
            let inputs = formGenerateNotification.find('textarea');

            let isValid = true;

            inputs.each(function() {
                let $input = $(this); // Convertir a objeto jQuery
                let value = $input.val();

                if (value.trim() === '') {
                    $input.addClass('is-invalid');
                    isValid = false;
                    showError(this, 'Debe completar este campo');
                } else {
                    $input.removeClass('is-invalid');
                    hideError(this);
                }
            });

            if (isValid) {
                formGenerateNotification.submit();
            }
        }


        function sendFreightInformation() {
            console.log("enviado para cambiar de estado");
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
    </script>
@endpush
