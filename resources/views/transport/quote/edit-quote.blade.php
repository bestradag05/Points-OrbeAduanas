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

            <form action={{ url('/quote/transport/' . $quote->id) }} id="storeQuoteEdit" method="POST"
                enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                @include ('transport.quote.form-quote', ['formMode' => 'edit'])
            </form>

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
                // Array para almacenar los nombres de archivos subidos

                // Archivos existentes desde el servidor
                let existingFiles = @json($files);

                if (!existingFiles) {
                    // Crear un input oculto para cada archivo existente
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'uploaded_files[]'; // Array para nombres de archivos
                    input.value = ''; // El nombre del archivo
                    document.getElementById('storeQuoteEdit').appendChild(
                        input); // Asume que el formulario tiene un div con id storeQuoteEdit
                }


                existingFiles.forEach(file => {
                    let mockFile = {
                        name: file.name, // Nombre del archivo
                        size: file.size, // Tamaño del archivo
                        url: file.url, // URL para mostrar el archivo
                        temp: false
                    };

                    // Si es un PDF, asigna una imagen predeterminada
                    if (/\.pdf$/i.test(file.name)) {
                        mockFile.thumbnail =
                            'https://static.vecteezy.com/system/resources/previews/023/234/824/non_2x/pdf-icon-red-and-white-color-for-free-png.png'; // Establecer la ruta de la imagen predeterminada
                    }
                    // Añade el archivo a Dropzone
                    this.emit("addedfile", mockFile);


                    // Si es una imagen, genera una vista en miniatura
                    if (/\.(jpg|jpeg|png|gif)$/i.test(file.name)) {
                        this.emit("thumbnail", mockFile, file.url);
                    } else if (/\.pdf$/i.test(file.name)) {
                        // Si es un PDF, usa la imagen predeterminada
                        this.emit("thumbnail", mockFile, mockFile.thumbnail);
                    }


                    // Marca el archivo como subido
                    this.emit("complete", mockFile);


                    // Crear un input oculto para cada archivo existente
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'uploaded_files[]'; // Array para nombres de archivos
                    input.value = file.name; // El nombre del archivo
                    document.getElementById('storeQuoteEdit').appendChild(
                        input); // Asume que el formulario tiene un div con id storeQuoteEdit


                });

                this.on('success', function(file, response) {

                    // Crear un input oculto para cada archivo subido
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'uploaded_files[]'; // Array para nombres de archivos
                    input.value = response.filename;
                    document.getElementById('storeQuoteEdit').appendChild(input);


                    const hiddenInput = document.querySelector(
                        `input[name="uploaded_files[]"][value=""]`);
                    if (hiddenInput) {
                        hiddenInput.parentNode.removeChild(hiddenInput);
                    }


                });

                this.on('removedfile', function(file) {

                    if (file && file.temp === undefined) {

                        axios.post('/quote/transport/file-delete-documents', {
                                filename: file.name,

                            }, {
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => {
                                console.log('Archivo eliminado:', response.data);
                            })
                            .catch(error => {
                                console.error('Error al eliminar el archivo:', error);
                            });
                    }

                    // Eliminar el input oculto asociado al archivo eliminado
                    const hiddenInput = document.querySelector(
                        `input[name="uploaded_files[]"][value="${file.name}"]`);
                    if (hiddenInput) {
                        hiddenInput.parentNode.removeChild(hiddenInput);
                    }

                    // Crear un input oculto para cada archivo existente
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'uploaded_files[]'; // Array para nombres de archivos
                    input.value = ''; // El nombre del archivo
                    document.getElementById('storeQuoteEdit').appendChild(
                        input); // Asume que el formulario tiene un div con id storeQuoteEdit


                });
            }
        };
    </script>
@endpush
