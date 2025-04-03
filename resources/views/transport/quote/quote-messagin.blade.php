@extends('home')


@section('dinamic-content')

    <div class="row">

        {{-- <div class="col-12  mb-4 text-right">
            <a href="{{ url('/quote/freight') }}" class="btn btn-primary"> Atras </a>
        </div> --}}
        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
            <div class="card direct-chat direct-chat-primary h-100">
                <div class="card-header bg-sisorbe-100 py-2">
                    <h5 class="text-center text-bold text-uppercase text-indigo">Cotizacion : {{ $quote->nro_quote }}</h5>
                </div>
                <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                    <div class="direct-chat-messages h-100">
                        @foreach ($messages as $message)
                            <div class="direct-chat-msg {{ $message->sender_id != auth()->user()->id ? 'right' : '' }}">
                                <div class="direct-chat-infos clearfix">
                                    <span
                                        class="direct-chat-name float-left text-indigo text-bold">{{ $message->sender->personal->names }}</span>
                                    <span
                                        class="direct-chat-timestamp float-right text-bold">{{ $message->created_at }}</span>
                                </div>
                                @if ($message->sender->personal->img_url !== null)
                                    <img src="{{ asset('storage/' . $message->sender->personal->img_url) }}"
                                        class="direct-chat-img" alt="User Image">
                                @else
                                    <img src="{{ asset('storage/personals/user_default.png') }}" class="direct-chat-img"
                                        alt="User Image">
                                @endif
                                <div class="direct-chat-text">
                                    {!! $message->message !!}
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="card-footer">
                    <form action="/quote/transport/message" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <textarea id="quote-text" name="message"></textarea>
                                <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                            </div>
                            <div class="col-12 row align-items-center justify-content-center mt-2">
                                <button type="submit" {{ $quote->state === 'Aceptada' ? 'disabled' : '' }}
                                    class="btn btn-indigo">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2 px-4">
            <h5 class="text-indigo text-center"><i class="fas fa-file-alt"></i> Detalle de carga</h5>

            <br>
            <div class="">
                <p class="text-sm">N° Cotizacion General :
                    <b class="d-block">{{ $quote->nro_quote_commercial }}</b>
                </p>
            </div>

            <div class="row text-muted">
                <div class="col-6">
                    <p class="text-sm">N° Cotizacion :
                        <b class="d-block">{{ $quote->nro_quote }}</b>
                    </p>
                </div>
                <div class="col-6 {{ $quote->commercial_quote->customer_company_name ? '' : 'd-none' }}">
                    <p class="text-sm">Cliente :
                        <b class="d-block">{{ $quote->commercial_quote->customer_company_name }}</b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">Origen :
                        <b class="d-block">{{ $quote->pick_up }}</b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">Destino :
                        <b class="d-block">{{ $quote->delivery }}</b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">Tipo de embarque :
                        <b class="d-block">{{ $quote->commercial_quote->type_shipment->description }}
                            {{ $quote->commercial_quote->lcl_fcl != null ? '(' . $quote->commercial_quote->lcl_fcl . ')' : '' }}</b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">Tipo de carga :
                        <b class="d-block">{{ $quote->load_type }}</b>
                    </p>
                </div>



            </div>

            @if ($quote->commercial_quote->is_consolidated)
                <div class="row text-muted">
                    <div class="col-6">
                        <p class="text-sm">Consolidado :
                            <b class="d-block"> SI </b>
                        </p>
                    </div>
                </div>

                <h5 class="text-center text-indigo" style="text-decoration: underline;  text-underline-offset: 4px;">Detalle
                    de consolidado</h5>

                @foreach ($quote->commercial_quote->consolidatedCargos as $consolidated)
                    @php
                        $shipper = json_decode($consolidated->supplier_temp);
                        $measures = json_decode($consolidated->value_measures);
                    @endphp


                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="accordion" id="accordionConsolidated">
                            <div>
                                <h2 class="mb-0">
                                    <button
                                        class="btn btn-link btn-block px-0 text-muted text-semibold text-left d-flex align-items-center"
                                        type="button" data-toggle="collapse"
                                        data-target="#collapse{{ $consolidated->id }}" aria-expanded="true">
                                        <span class="text-indigo">Shipper {{ $loop->iteration }}</span>:
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
                <div class="row text-muted">
                    <div class="col-6">
                        <p class="text-sm">Descripcion :
                            <b class="d-block">{{ $quote->commodity }}</b>
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="text-sm">Tipo de embalaje :
                            <b class="d-block">{{ $quote->packaging_type }}</b>
                        </p>
                    </div>
                </div>

                @if ($quote->commercial_quote->lcl_fcl === 'LCL' || $quote->commercial_quote->lcl_fcl === null)
                    <div class="row text-muted">
                        <div class="col-6">
                            <p class="text-sm">Cubicaje/KGV :
                                <b class="d-block">{{ $quote->cubage_kgv }}</b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="text-sm">Peso total :
                                <b class="d-block">{{ $quote->total_weight }}</b>
                            </p>
                        </div>
                    </div>
                @else
                    <div class="row text-muted">
                        <div class="col-6">
                            <p class="text-sm">Tipo de contenedor :
                                <b class="d-block">{{ $quote->container_type }}</b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="text-sm">Toneladas/Kilogramos :
                                <b class="d-block">{{ $quote->ton_kilogram }}</b>
                            </p>
                        </div>
                    </div>
                @endif


                @if ($quote->commercial_quote->measures)

                    <div class="col-6">
                        <p class="text-sm">Medidas : </p>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <th>Cantidad</th>
                            <th>Ancho</th>
                            <th>Largo</th>
                            <th>Alto</th>
                            <th>Unidad</th>
                        </thead>
                        <tbody>
                            @foreach (json_decode($quote->commercial_quote->measures) as $measure)
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

            @endif



            <div class="row text-muted mt-3">
                <div class="col-6">
                    <p class="text-uppercase ">Estado :
                        <b class="status-{{ strtolower($quote->state) }}">{{ $quote->state }}</b>
                        <b class="status-{{ strtolower($quote->state) }}"><i class="fas fa-circle"></i></b>

                    </p>
                </div>

            </div>

            <hr>
            <div class="row align-items-center">
                <div class="col-6 align-items-center">
                    <h5 class="mt-3 text-muted">Archivos : </h5>
                </div>
                <div class="col-6 align-items-center {{ $quote->state === 'Aceptado' ? 'd-none' : '' }}">
                    <button class="btn btn-indigo btn-sm" data-toggle="modal"
                        data-target="#modalQuoteTransportDocuments">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <table id="table-file-transport" class="table">
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td>
                                <a href="{{ $file['url'] }}" target="_blank" class="btn-link text-secondary">
                                    <i class="far fa-fw fa-file-pdf"></i> {{ $file['name'] }}
                                </a>
                            </td>
                            <td class="text-center {{ $quote->state === 'Aceptado' ? 'd-none' : '' }}"">
                                <a href="#" class="text-danger"
                                    onclick="handleFileDeletion('{{ $file['name'] }}', this, event)">
                                    X
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>
            @if ($quote->cost_transport != null && $quote->state === 'Aceptada')
                <div class="row">

                    <div class="col-12">
                        <h6 class="text-indigo text-center mb-3 text-bold"><i class="fas fa-dollar-sign"></i> Detalle de
                            costos
                        </h6>
                    </div>

                    <div class="col-12 ml-4">

                        <div class="row text-muted">
                            <div class="col-4">
                                <p class="text-sm">Flete :
                                </p>
                            </div>
                            <div class="col-6">
                                <b class="d-inline">$ {{ $quote->cost_transport }}</b>
                            </div>

                        </div>
                        @if ($quote->gang === 'SI')
                            <div class="row text-muted">
                                <div class="col-4">
                                    <p class="text-sm">Cuadrilla :
                                    </p>
                                </div>
                                <div class="col-6">
                                    <b class="d-inline">$ {{ $quote->cost_gang }}</b>
                                </div>

                            </div>
                        @endif
                        @if ($quote->guard === 'SI')
                            <div class="row text-muted">
                                <div class="col-4">
                                    <p class="text-sm">Reguardo :
                                    </p>
                                </div>
                                <div class="col-6">
                                    <b class="d-inline">$ {{ $quote->cost_guard }}</b>
                                </div>

                            </div>
                        @endif



                        <div class="row text-muted mt-3 ">
                            <div class="col-12 row justify-content-center">
                                <p class="text-uppercase text-bold text-lg">Costo del Transporte :
                                    <b class="status-{{ strtolower($quote->state) }}">$
                                        {{ $quote->total_transport }}</b>
                                </p>
                            </div>

                        </div>


                    </div>


                </div>
            @endif


            <div class="text-center mt-5 mb-3">
                <button class="btn btn-sm btn-success {{ $quote->state === 'Aceptado' ? 'd-none' : '' }}" type="button"
                    data-toggle="modal" data-target="#quote-transport">Cotización Aceptada</button>

            </div>
        </div>
    </div>


    <div id="quote-transport" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="quote-transport-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action={{ url('/quote/transport/cost/accept/' . $quote->id) }} id="sendTransportCost"
                    method="POST">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="quote-transport-title">{{ $quote->nro_quote }}</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="cost_transport">Transporte</label>
                            <input id="cost_transport" data-type="currency" class="form-control CurrencyInput"
                                type="text" name="cost_transport">
                        </div>
                        @if ($quote->gang && $quote->gang === 'SI')
                            <div class="form-group">
                                <label for="cost_gang">Cuadrilla</label>
                                <input id="cost_gang" data-type="currency" class="form-control CurrencyInput"
                                    type="text" name="cost_gang">
                            </div>
                        @endif
                        @if ($quote->guard && $quote->guard === 'SI')
                            <div class="form-group">
                                <label for="cost_guard">Resguardo</label>
                                <input id="cost_guard" data-type="currency" class="form-control CurrencyInput"
                                    type="text" name="cost_guard">
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="cost_transport">Fecha aproximada de retiro</label>
                            <input type="date" class="form-control" id="withdrawal_date" name="withdrawal_date"
                                placeholder="Ingrese el destino">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cerrar Cotización</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalQuoteTransportDocuments" tabindex="-1"
        aria-labelledby="modalQuoteTransportDocumentsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalQuoteTransportDocumentsLabel">Documentos de transporte</h5>
                </div>
                <div class="modal-body">
                    <form action="quote/transport/file-upload-documents" method="post" enctype="multipart/form-data"
                        class="dropzone" id="myDropzone">
                        @csrf
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@stop


@push('scripts')
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#quote-text').summernote();
        });


        $('#sendTransportCost').on('submit', (e) => {

            e.preventDefault();

            let isValid = true; // Bandera para comprobar si el formulario es válido
            let form = e.target;
            const inputs = form.querySelectorAll('input');


            inputs.forEach((input) => {
                // Ignorar campos ocultos (d-none)
                if (input.closest('.d-none')) {
                    return;
                }

                // Validar si el campo está vacío
                if (input.value.trim() === '') {
                    input.classList.add('is-invalid');
                    isValid = false; // Cambiar bandera si algún campo no es válido
                    showError(input, 'Debe completar este campo');
                } else {
                    input.classList.remove('is-invalid');
                    hideError(input);
                }
            });


            if (isValid) {
                form.submit();
            }

        })



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
    <script>
        let commercial_quote = @json($quote->nro_quote_commercial);
        let transport_quote = @json($quote->nro_quote);


        Dropzone.options.myDropzone = {

            url: '/quote/transport/file-upload-documents', // Ruta para subir los archivos
            maxFilesize: 2, // Tamaño máximo en MB
            acceptedFiles: '.jpg,.jpeg,.png,.gif,.pdf', // Tipos permitidos
            autoProcessQueue: true, // Subir automáticamente al añadir
            params: {
                commercial_quote,
                transport_quote // Envía este dato adicional al servidor
            },

            init: function() {
                let uploadedFiles = []; // Almacena los nombres de archivos subidos
                let myDropzone = this;

                let tableBody = document.querySelector("#table-file-transport tbody");

                this.on('addedfile', function(file) {
                    // Si el archivo es PDF, asigna una miniatura personalizada (imagen predeterminada)
                    if (/\.pdf$/i.test(file.name)) {
                        // Usamos la URL de la imagen predeterminada para los PDFs
                        let pdfThumbnailUrl =
                            'https://static.vecteezy.com/system/resources/previews/023/234/824/non_2x/pdf-icon-red-and-white-color-for-free-png.png'; // Cambia esto por la ruta de tu imagen predeterminada
                        this.emit("thumbnail", file, pdfThumbnailUrl);
                    }




                    let existingFile = uploadedFiles.find(item => item.filename === file.name);
                    if (existingFile) {
                        myDropzone.removeFile(existingFile.file);
                        existingFile.row.remove();
                        uploadedFiles = uploadedFiles.filter(item => item.filename !== file.name);
                    }


                })

                this.on('success', function(file, response) {

                    let row = document.createElement("tr");

                    let fileCell = document.createElement("td");
                    let link = document.createElement("a");
                    link.href = response.url;
                    link.target = "_blank";
                    link.className = "btn-link text-secondary";
                    link.innerHTML = `<i class="far fa-fw fa-file-pdf"></i> ${response.filename}`;
                    fileCell.appendChild(link);


                    //Creamos el boton de eliminar

                    // Columna del botón eliminar
                    let actionCell = document.createElement("td");
                    actionCell.className = "text-center";
                    let removeButton = document.createElement("a");
                    removeButton.href = "#";
                    removeButton.className = "text-danger";
                    removeButton.textContent = "X";


                    removeButton.addEventListener('click', function(event) {
                        event.preventDefault();

                        axios.post('/quote/transport/file-delete-documents', {

                            filename: response.filename,
                            commercial_quote,
                            transport_quote

                        }).then(response => {

                            row.remove();
                            // Eliminar de Dropzone
                            myDropzone.removeFile(file);

                        }).catch(error => {
                            console.error('Error al eliminar el archivo:', error);
                        });
                    });


                    actionCell.appendChild(removeButton);
                    row.appendChild(fileCell);
                    row.appendChild(actionCell);

                    tableBody.appendChild(row);

                    console.log(tableBody);

                    // Guardar en el mapa de archivos subidos
                    /* uploadedFiles.set(response.filename, listItem); */


                    uploadedFiles.push({
                        "filename": file.name,
                        "row": row,
                        "file": file
                    });


                });

            }
        };

        function handleFileDeletion(filename, element, e) {

            e.preventDefault();

            axios.post('/quote/transport/file-delete-documents', {
                filename: filename,
                commercial_quote,
                transport_quote
            }).then(response => {
                let listItem = element.parentElement;
                row.remove();
            }).catch(error => {
                console.error('Error al eliminar el archivo:', error);
            });
        }
    </script>
@endpush
