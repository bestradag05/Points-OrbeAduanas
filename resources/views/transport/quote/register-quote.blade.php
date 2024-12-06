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

            <form action="/quote/transport" method="post" enctype="multipart/form-data">
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
                    <form action="/quote/transport/file-upload-documents" method="post" enctype="multipart/form-data" class="dropzone" id="myDropzone">
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

                    this.on('success', function(file, response) {
                        // Agregar nombre del archivo subido a la lista
                        uploadedFiles.push(response.filename);

                        // Crear un input oculto para cada archivo subido
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'uploaded_files[]'; // Array para nombres de archivos
                        input.value = response.filename;
                        document.querySelector('form').appendChild(input);
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

                        // Remover el archivo del DOM
                        const previewElement = file.previewElement;
                        if (previewElement) {
                            previewElement.parentNode.removeChild(previewElement);
                        }
                    });
                }
            };



    </script>
@endpush
