@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Cotizacion de Flete</h2>
        <div>
            <a href="{{ url('/quote') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')

    <div class="row flex-row">
        <div class="col-12 row justify-content-center mb-3">
            <button class="btn btn-indigo" data-toggle="modal" data-target="#modalQuoteFreightDocuments">
                Agregar Documentos
            </button>
        </div>

        <div class="col-12">

            <form action="/quote/freight" id="storeQuote" method="post" enctype="multipart/form-data">
                @csrf
                @include ('freight.quote.form-quote', ['formMode' => 'create'])
            </form>


        </div>


    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalQuoteFreight" tabindex="-1" aria-labelledby="modalQuoteFreightLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalQuoteFreightLabel">Operacion</h5>
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
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modalQuoteFreightDocuments" tabindex="-1" aria-labelledby="modalQuoteFreightDocumentsLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalQuoteFreightDocumentsLabel">Documentos de transporte</h5>
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

            url: '/quote/freight/file-upload-documents', // Ruta para subir los archivos
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
                    if (file) {
                        axios.post('/quote/freight/file-delete-documents', {

                            filename: file.name

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
                var myModal = new bootstrap.Modal(document.getElementById('modalQuoteFreight'), {
                    backdrop: 'static', // Evita cierre al hacer clic fuera
                    keyboard: false // Evita cierre con la tecla ESC
                });

                myModal.show();


            })
        </script>
    @endif
@endpush
