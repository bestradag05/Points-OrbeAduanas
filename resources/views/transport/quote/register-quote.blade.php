@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Cotizacion de transporte</h2>
        <div>
            <a href="{{ url('/quote') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')

    <div class="row flex-row">
        <div class="col-12 row justify-content-center mb-3">
            <button class="btn btn-indigo" data-toggle="modal" data-target="#modalQuoteTransportDocuments">
                Agregar Documentos
            </button>
        </div>

        <div class="col-12">

            <form action="/quote/transport" id="storeQuote" method="post" enctype="multipart/form-data">
                @csrf
                @include ('transport.quote.form-quote', ['formMode' => 'create'])
            </form>


        </div>


    </div>



    <!-- Modal -->
    <div class="modal fade" id="modalQuoteTransport" tabindex="-1" aria-labelledby="modalQuoteTransportLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalQuoteTransportLabel">Operacion</h5>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" name="modal_nro_operation" id="modal_nro_operation"
                        placeholder="Ingrese su numero de operacion">

                    <span id="error_nro_operation" class="invalid-feedback d-none" role="alert">
                        <strong id="texto_nro_operation"></strong>
                    </span>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" id="searchRouting" class="btn btn-primary">Buscar operacion</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Generar cotizacion manual</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Manual para cotizacion --}}


    <div class="modal fade" id="modalQuoteTransportManual" tabindex="-1" aria-labelledby="modalQuoteTransportManualLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalQuoteTransportManualLabel">Operacion</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="type_shipment">Tipo de embarque</label>
                        <select id="type_shipment" class="form-control" name="type_shipment">
                            <option selected disabled>--- Seleccione una opción ---</option>
                            <option value="Aérea">Aereo</option>
                            <option value="Marítima">Maritimo</option>
                        </select>
                    </div>


                    <div id="contenedor_radio_lcl_fcl" class="d-none text-center">
                        <div class="form-check d-inline">
                            <input type="radio" id="radioLcl" name="lcl_fcl" value="LCL"
                                {{ (isset($routing->lcl_fcl) && $routing->lcl_fcl === 'LCL') || old('lcl_fcl') === 'LCL' ? 'checked' : '' }}
                                class="form-check-input @error('lcl_fcl') is-invalid @enderror">
                            <label for="radioLclFcl" class="form-check-label">
                                LCL
                            </label>
                        </div>
                        <div class="form-check d-inline">
                            <input type="radio" id="radioFcl" name="lcl_fcl" value="FCL"
                                {{ (isset($routing->lcl_fcl) && $routing->lcl_fcl === 'FCL') || old('lcl_fcl') === 'FCL' ? 'checked' : '' }}
                                class="form-check-input @error('lcl_fcl') is-invalid @enderror">
                            <label for="radioLclFcl" class="form-check-label">
                                FCL
                            </label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" id="generateQuote" class="btn btn-primary">Generar Cotización</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalQuoteTransportDocuments" tabindex="-1"
        aria-labelledby="modalQuoteTransportDocumentsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalQuoteTransportDocumentsLabel">Documentos de transporte</h5>
                </div>
                <div class="modal-body">
                    <form action="/quote/transport/file-upload-documents" method="post" enctype="multipart/form-data"
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
    <script>
        Dropzone.options.myDropzone = {

            url: '/quote/transport/file-upload-documents', // Ruta para subir los archivos
            maxFilesize: 2, // Tamaño máximo en MB
            acceptedFiles: '.jpg,.jpeg,.png,.gif,.pdf', // Tipos permitidos
            addRemoveLinks: true,
            dictRemoveFile: "Remove", // Agregar opción para eliminar archivos
            autoProcessQueue: true, // Subir automáticamente al añadir

            init: function() {
                let uploadedFiles = []; // Array para almacenar los nombres de archivos subidos


                this.on('addedfile', function(file) {
                    // Si el archivo es PDF, asigna una miniatura personalizada (imagen predeterminada)
                    if (/\.pdf$/i.test(file.name)) {
                        // Usamos la URL de la imagen predeterminada para los PDFs
                        let pdfThumbnailUrl =
                            'https://static.vecteezy.com/system/resources/previews/023/234/824/non_2x/pdf-icon-red-and-white-color-for-free-png.png'; // Cambia esto por la ruta de tu imagen predeterminada
                        this.emit("thumbnail", file, pdfThumbnailUrl);
                    }
                });


                this.on('success', function(file, response) {
                    uploadedFiles.push(response.filename);

                    // Crear un input oculto para cada archivo subido
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'uploaded_files[]'; // Array para nombres de archivos
                    input.value = response.filename;
                    document.getElementById('storeQuote').appendChild(input);


                });

                this.on('removedfile', function(file) {
                    console.log(file);
                    if (file) {
                        axios.delete('/quote/transport/file-delete-documents', {
                            data: {
                                filename: file.name
                            }
                        }).then(response => {
                            console.log('Archivo eliminado:', response.data);
                        }).catch(error => {
                            console.error('Error al eliminar el archivo:', error);
                        });
                    }


                    // Eliminar el input oculto asociado al archivo eliminado
                    const hiddenInput = document.querySelector(
                        `input[name="uploaded_files[]"][value="${file.name}"]`);
                    if (hiddenInput) {
                        hiddenInput.parentNode.removeChild(hiddenInput);
                    }


                });
            }
        };
    </script>
    @if ($showModal ?? false)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('modalQuoteTransport'), {
                    backdrop: 'static', // Evita cierre al hacer clic fuera
                    keyboard: false // Evita cierre con la tecla ESC
                });

                myModal.show();

                $('.customer_quote_manual').addClass('d-none');
                $('.customer_quote').removeClass('d-none');

                $('#modalQuoteTransport').on('hidden.bs.modal', function(e) {
                    $('#modalQuoteTransportManual').modal('show', {
                        backdrop: 'static', // Evita cierre al hacer clic fuera
                        keyboard: false
                    });

                    $('.customer_quote_manual').removeClass('d-none');
                    $('.customer_quote').addClass('d-none');

                })


                if (volumenValue.value !== '' || volumenValue.classList.contains('is-invalid')) {
                  $('#contenedor_volumen').removeClass('d-none');
                  $('#contenedor_kg_vol').addClass('d-none');
              }



            });


            $('#type_shipment').on('change', (e) => {

                let type = e.target.value;
                if (type === "Marítima") {

                    /*  $('#type_shipment_name').val(respu.description); */

                    $('#contenedor_radio_lcl_fcl').removeClass('d-none');


                } else {

                    $('#contenedor_radio_lcl_fcl').addClass('d-none');
                    $('input[name="lcl_fcl"]').prop('checked', false);

                }

            });


            $('#generateQuote').on('click', (e) => {


                let typeShipment = $('#type_shipment').val();
                let radio = $('input[name="lcl_fcl"]:checked').val();


                // Verificar si están vacíos
                if (!typeShipment) {
                    $('#type_shipment').addClass('is-invalid'); // Agregar clase si está vacío
                    return;
                } else {
                    $('#type_shipment').removeClass('is-invalid'); // Quitar clase si tiene valor

                    if (typeShipment === "Marítima") {

                        if (!radio) {
                            $('input[name="lcl_fcl"]').closest('.form-check').find('input').addClass(
                                'is-invalid'); // Agregar clase a todos los radios del grupo
                            return;
                        } else {
                            $('input[name="lcl_fcl"]').removeClass(
                                'is-invalid'); // Quitar clase si hay un valor seleccionado
                        }

                    }

                }

                //Si pasa las validaciones entonces mostramos la cotizacion ideal para el tipo de embarque:

                if (radio === 'LCL' || !radio) {
                    $('#title_quote span').text('LCL');

                    $('.lcl_quote').removeClass('d-none');
                    $('.fcl_quote').addClass('d-none');


                } else {
                    $('#title_quote span').text('FCL');
                    $('.lcl_quote').addClass('d-none');
                    $('.fcl_quote').removeClass('d-none');
                }

                if (radio != "FCL") {

                    $('#lcl_fcl').val("LCL");
                } else {
                    $('#lcl_fcl').val('FCL');
                }


                // Cerrar el modal utilizando la instancia nativa de Bootstrap
                $('#modalQuoteTransportManual').modal('hide');


            })
        </script>
    @endif
@endpush
