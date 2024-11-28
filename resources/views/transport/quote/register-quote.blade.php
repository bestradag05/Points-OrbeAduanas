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
    <form action="/quote" method="post" enctype="multipart/form-data">
        @csrf
        @include ('transport.quote.form-quote', ['formMode' => 'create'])
    </form>



    <!-- Modal -->
    <div class="modal fade" id="modalQuoteTransport" tabindex="-1" aria-labelledby="modalQuoteTransportLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="        modalQuoteTransportLabel">Operacion</h5>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" name="nro_operation" id="nro_operation"
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

                const nro_operation = $('#nro_operation').val().trim();

                if (nro_operation === '') {

                    $('#nro_operation').addClass('is-invalid');
                    $('#error_nro_operation').removeClass('d-block').addClass('d-none');

                } else {
                    $('#nro_operation').removeClass('is-invalid');

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
                            $('#nro_operation').addClass('is-invalid');

                        }
                    });

                }



            });



            function loadInfoRouting(data) {

                $('#customer').val(data.customer.name_businessname).prop('readonly', true);
                $('#contact_name').val(data.customer.contact_name);
                $('#contact_phone').val(data.customer.contact_number);
                $('#load_type').val(data.type_load.name).prop('readonly', true);
                $('#commodity').val(data.commodity).prop('readonly', true);
                //aqui falta el tipo de embalaje
                /* $('#customer').val(data.customer.name_businessname); */
                $('#cubage_kgv').val(data.volumen).prop('readonly', true);
                $('#total_weight').val(data.kilograms).prop('readonly', true);
                $('#packages').val(data.nro_package).prop('readonly', true);


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
        </script>
    @endif
@endpush
