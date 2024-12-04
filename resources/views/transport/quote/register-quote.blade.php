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
    <form action="/quote/transport" method="post" enctype="multipart/form-data">
        @csrf
        @include ('transport.quote.form-quote', ['formMode' => 'create'])
    </form>



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


@stop



@push('scripts')
    @if ($showModal ?? false)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('modalQuoteTransport'), {
                    backdrop: 'static', // Evita cierre al hacer clic fuera
                    keyboard: false // Evita cierre con la tecla ESC
                });
                myModal.show();

            });


            $('#searchRouting').on('click', () => {

                const nro_operation = $('#modal_nro_operation').val().trim();

                if (nro_operation === '') {

                    $('#modal_nro_operation').addClass('is-invalid');
                    $('#error_nro_operation').removeClass('d-block').addClass('d-none');

                } else {
                    $('#modal_nro_operation').removeClass('is-invalid');

                    // Realizar solicitud AJAX
                    $.ajax({
                        url: `/quote/search-routing/${nro_operation}`, // Cambia esto por la URL de tu servidor
                        type: 'GET',
                        success: function(response) {
                            // Manejo de la respuesta exitosa

                            loadInfoRouting(response.data[0]);


                        },
                        error: function(xhr, status, error) {
                            // Manejo del error
                            var errorMessage = xhr.responseJSON ? xhr.responseJSON.message :
                                'Ocurrió un error inesperado.';

                            // Mostrar el mensaje de error al usuario
                            $('#error_nro_operation').removeClass('d-none').addClass('d-block');
                            $('#texto_nro_operation').text(errorMessage);
                            $('#modal_nro_operation').addClass('is-invalid');

                        }
                    });

                }



            });



            function loadInfoRouting(data) {

                console.log(data);
                if (data.lcl_fcl === 'LCL' || data.lcl_fcl === null) {
                    $('#title_quote span').text('LCL');

                    $('.lcl_quote').removeClass('d-none');
                    $('.fcl_quote').addClass('d-none');


                } else {
                    $('#title_quote span').text('FCL');
                    $('.lcl_quote').addClass('d-none');
                    $('.fcl_quote').removeClass('d-none');
                }

                $('#customer').val(data.customer.name_businessname).prop('readonly', true);
                $('#contact_name').val(data.customer.contact_name);
                $('#contact_phone').val(data.customer.contact_number);
                $('#load_type').val(data.type_load.name).prop('readonly', true);
                $('#commodity').val(data.commodity).prop('readonly', true);
                $('#packaging_type').val(data.packaging_type).prop('readonly', true);

                if(data.type_shipment.description === "Marítima" && data.lcl_fcl === 'LCL'){
                    $('#cubage_kgv').val(data.volumen + ' m3').prop('readonly', true);
                }

                if(data.type_shipment.description === "Aérea" && data.lcl_fcl === null){
                    $('#cubage_kgv').val(data.kilogram_volumen + ' KGV').prop('readonly', true);
                }
               
                $('#ton_kilogram').val(data.volumen).prop('readonly', true);
                $('#total_weight').val(data.kilograms).prop('readonly', true);
                $('#packages').val(data.nro_package).prop('readonly', true);
                $('#measures').val(data.measures);
                //Campos Hidden
                $('#nro_operation').val(data.nro_operation);
                if(data.lcl_fcl != null){
                    
                    $('#lcl_fcl').val(data.lcl_fcl);
                }else{
                    $('#lcl_fcl').val('LCL');
                }

                //load Table measures
                populateTable(JSON.parse(data.measures));


                // Cerrar el modal utilizando la instancia nativa de Bootstrap
                $('#modalQuoteTransport').hide();

                // Eliminar manualmente el backdrop si persiste
                const modalBackdrop = document.querySelector('.modal-backdrop');
                if (modalBackdrop) {
                    modalBackdrop.remove();
                }

                // Eliminar la clase `modal-open` del body para restaurar el scroll
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = ''


            }



            function populateTable(data) {
                const tableBody = document.getElementById('table_measures').getElementsByTagName('tbody')[0];

                // Limpiar la tabla antes de agregar nuevos datos
                tableBody.innerHTML = '';

                // Iterar sobre los datos y agregar una fila por cada objeto
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        const item = data[key]; // Accede al objeto de cada clave

                        // Crear una nueva fila
                        let row = tableBody.insertRow();

                        // Insertar celdas en la fila y agregar los valores
                        let cellAmount = row.insertCell(0);
                        cellAmount.textContent = item.amount;

                        let cellHeight = row.insertCell(1);
                        cellHeight.textContent = item.height;

                        let cellLength = row.insertCell(2);
                        cellLength.textContent = item.length;

                        let cellWidth = row.insertCell(3);
                        cellWidth.textContent = item.width;
                    }
                }

            }
        </script>
    @else
        <script>
            // Cerrar el modal utilizando la instancia nativa de Bootstrap
            $('#modalQuoteTransport').hide();

            // Eliminar manualmente el backdrop si persiste
            const modalBackdrop = document.querySelector('.modal-backdrop');
            if (modalBackdrop) {
                modalBackdrop.remove();
            }

            // Eliminar la clase `modal-open` del body para restaurar el scroll
            document.body.classList.remove('modal-open');
            document.body.style.paddingRight = ''


            const nro_operation = $('#nro_operation').val();


            // Realizar solicitud AJAX
            $.ajax({
                url: `/quote/search-routing/${nro_operation}`, // Cambia esto por la URL de tu servidor
                type: 'GET',
                success: function(response) {
                    // Manejo de la respuesta exitosa

                    loadInfoRouting(response.data[0]);


                },
                error: function(xhr, status, error) {
                    // Manejo del error
                    var errorMessage = xhr.responseJSON ? xhr.responseJSON.message :
                        'Ocurrió un error inesperado.';

                    // Mostrar el mensaje de error al usuario
                    $('#error_nro_operation').removeClass('d-none').addClass('d-block');
                    $('#texto_nro_operation').text(errorMessage);
                    $('#modal_nro_operation').addClass('is-invalid');

                }
            });


            function loadInfoRouting(data) {

                $('#title_quote span').text(data.lcl_fcl);


                if (data.lcl_fcl === 'LCL' || data.lcl_fcl === null) {
                    $('#title_quote span').text('LCL');

                    $('.lcl_quote').removeClass('d-none');
                    $('.fcl_quote').addClass('d-none');


                } else {
                    $('#title_quote span').text('FCL');
                    $('.lcl_quote').addClass('d-none');
                    $('.fcl_quote').removeClass('d-none');
                }

                $('#customer').val(data.customer.name_businessname).prop('readonly', true);
                $('#contact_name').val(data.customer.contact_name);
                $('#contact_phone').val(data.customer.contact_number);
                $('#load_type').val(data.type_load.name).prop('readonly', true);
                $('#commodity').val(data.commodity).prop('readonly', true);
                $('#packaging_type').val(data.packaging_type).prop('readonly', true);
                if(data.type_shipment.description === "Marítima" && data.lcl_fcl === 'LCL'){
                    $('#cubage_kgv').val(data.volumen + ' m3').prop('readonly', true);
                }

                if(data.type_shipment.description === "Aérea" && data.lcl_fcl === 'LCL'){
                    $('#cubage_kgv').val(data.kilogram_volumen+' KGV').prop('readonly', true);
                }
                $('#ton_kilogram').val(data.volumen).prop('readonly', true);
                $('#total_weight').val(data.kilograms).prop('readonly', true);
                $('#packages').val(data.nro_package).prop('readonly', true);
                $('#measures').val(data.measures);
                //Campos Hidden
                $('#nro_operation').val(data.nro_operation);
                if(data.lcl_fcl != null){
                    
                    $('#lcl_fcl').val(data.lcl_fcl);
                }else{
                    $('#lcl_fcl').val('LCL');
                }

                //load Table measures
                populateTable(JSON.parse(data.measures));


                // Cerrar el modal utilizando la instancia nativa de Bootstrap
                $('#modalQuoteTransport').hide();

                // Eliminar manualmente el backdrop si persiste
                const modalBackdrop = document.querySelector('.modal-backdrop');
                if (modalBackdrop) {
                    modalBackdrop.remove();
                }

                // Eliminar la clase `modal-open` del body para restaurar el scroll
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = ''


            }



            function populateTable(data) {
                const tableBody = document.getElementById('table_measures').getElementsByTagName('tbody')[0];

                // Limpiar la tabla antes de agregar nuevos datos
                tableBody.innerHTML = '';

                // Iterar sobre los datos y agregar una fila por cada objeto
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        const item = data[key]; // Accede al objeto de cada clave

                        // Crear una nueva fila
                        let row = tableBody.insertRow();

                        // Insertar celdas en la fila y agregar los valores
                        let cellAmount = row.insertCell(0);
                        cellAmount.textContent = item.amount;

                        let cellHeight = row.insertCell(1);
                        cellHeight.textContent = item.height;

                        let cellLength = row.insertCell(2);
                        cellLength.textContent = item.length;

                        let cellWidth = row.insertCell(3);
                        cellWidth.textContent = item.width;
                    }
                }

            }
        </script>
    @endif
@endpush
