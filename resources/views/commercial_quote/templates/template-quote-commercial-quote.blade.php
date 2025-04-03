<div class="col-12">

    <h4 class="text-indigo text-center text-bold text-uppercase my-4">Cotizaciones </h4>


    <div class="col-4 offset-4">

        @if ($comercialQuote->state === 'Pendiente')

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Agregar Cotizacion : </label>
                <div class="col-sm-8">
                    <select name="type_quote_service" id="type_quote_service" class="form-control"
                        onchange="createTypeQuote(this)">
                        <option disabled selected></option>
                        @if ($comercialQuote->quote_freight()->exists())
                            <option value="Flete" disabled>Flete</option>
                        @else
                            <option value="Flete">Flete</option>
                        @endif

                        @if ($comercialQuote->quote_transport()->exists())
                            <option value="Transporte" disabled>Transporte</option>
                        @else
                            <option value="Transporte">Transporte</option>
                        @endif

                    </select>


                </div>

            </div>

        @endif



    </div>

    {{-- Tabla para cotizaciones de flete --}}
    @if ($comercialQuote->quote_freight()->exists())
        <div class="col-12 mt-4">
            <h5 class="text-indigo  text-center">Flete</h5>

            <table class="table table-sm text-sm">
                <thead class="thead-dark">
                    <th>#</th>
                    <th>N° cotizacion</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">Producto</th>
                    <th class="{{ $comercialQuote->type_shipment->description === 'Marítima' ? '' : 'd-none' }}">
                        LCL / FCL</th>
                    <th class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">Cubicaje-KGV</th>
                    <th class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">Tonelada-KG</th>
                    <th>N° de operacion</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </thead>
                <tbody>


                    @foreach ($comercialQuote->quote_freight as $quote)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $quote->nro_quote }}</td>
                            <td>{{ $quote->origin }}</td>
                            <td>{{ $quote->destination }}</td>
                            <td class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">
                                {{ $quote->commodity }}</td>
                            <td
                                class="{{ $comercialQuote->type_shipment->description === 'Marítima' ? '' : 'd-none' }}">
                                {{ $quote->commercial_quote->lcl_fcl }}</td>
                            <td class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">
                                {{ $quote->cubage_kgv }}</td>
                            <td class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">
                                {{ $quote->ton_kilogram }}</td>
                            <td>{{ $quote->nro_quote_commercial }}</td>
                            <td>{{ \Carbon\Carbon::parse($quote->created_at)->format('d/m/Y') }}</td>
                            <td class="status-{{ strtolower($quote->state) }}">{{ $quote->state }}
                            </td>


                            <td style="width: 150px">
                                <select name="acction_transport" class="form-control form-control-sm"
                                    onchange="changeAcction(this, {{ $quote }}, 'Flete')">
                                    <option value="" disabled selected>Seleccione una acción...</option>
                                    <option>Detalle</option>
                                    <option class="{{ $quote->state != 'Pendiente' ? 'd-none' : '' }}">Anular
                                    </option>
                                    @if ($comercialQuote->state === 'Pendiente')
                                        <option class="{{ $quote->state != 'Aceptado' ? 'd-none' : '' }}">Rechazar
                                        </option>
                                    @endif
                                </select>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    @endif


    {{-- Tabla para cotizaciones de Transporte --}}
    @if ($comercialQuote->quote_transport()->exists())
        <div class="col-12 mt-4">
            <h5 class="text-indigo text-center">Transporte</h5>

            <table class="table table-sm text-sm">
                <thead class="thead-dark">
                    <th>#</th>
                    <th>N° cotizacion</th>
                    <th>Recojo</th>
                    <th>Entrega</th>
                    <th class="{{ $comercialQuote->type_shipment->description === 'Marítima' ? '' : 'd-none' }}">
                        LCL / FCL</th>
                    <th class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">Cubicaje-KGV</th>
                    <th class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">Tonelada-KG</th>
                    <th>N° de operacion</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </thead>
                <tbody>

                    @foreach ($comercialQuote->quote_transport as $quote)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $quote->nro_quote }}</td>
                            <td>{!! $quote->pick_up ? e($quote->pick_up) : '<span class="text-muted">Falta información</span>' !!}</td>
                            <td>{!! $quote->delivery ? e($quote->delivery) : '<span class="text-muted">Falta información</span>' !!}</td>
                            <td
                                class="{{ $comercialQuote->type_shipment->description === 'Marítima' ? '' : 'd-none' }}">
                                {{ $quote->commercial_quote->lcl_fcl }}</td>
                            <td class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">
                                {{ $quote->cubage_kgv }}</td>
                            <td class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">
                                {{ $quote->ton_kilogram }}</td>
                            <td>{{ $quote->nro_quote_commercial }}</td>
                            <td>{{ \Carbon\Carbon::parse($quote->created_at)->format('d/m/Y') }}</td>
                            <td class="status-{{ strtolower($quote->state) }}">{{ $quote->state }}
                            </td>

                            <td style="width: 150px">
                                <select name="acction_transport" class="form-control form-control-sm"
                                    onchange="changeAcction(this, {{ $quote }}, 'Transporte')">
                                    <option value="" disabled selected>Seleccione una acción...</option>
                                    <option>Detalle</option>
                                    <option class="{{ $quote->state != 'Pendiente' ? 'd-none' : '' }}">Anular
                                    </option>
                                    @if ($comercialQuote->state === 'Pendiente')
                                        <option class="{{ $quote->state != 'Aceptado' ? 'd-none' : '' }}">Rechazar
                                        </option>
                                    @endif

                                </select>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    @endif


</div>


{{-- Modal para completar informacion del transporte --}}

<div id="modalTransport" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTransport-title"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="formQuoteTransport">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTransport-title">Cotización de transporte</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-warning text-center">Para completar la cotizacion de transporte, por favor brinde la
                        siguiente información: </p>
                    <div class="form-group">
                        <label for="pick_up">Dirección de Recojo:</label>
                        <input id="pick_up" class="form-control" type="text" name="pick_up">
                    </div>
                    <div class="form-group">
                        <label for="delivery">Dirección de entrega</label>
                        <input id="delivery" class="form-control" type="text" name="delivery">
                    </div>

                    <div class="form-group" id="container_return">
                        <label for="container_return">Devolución de contenedor</label>
                        <input id="container_return" class="form-control" type="text" name="container_return">
                    </div>


                    <div class="form-group row" id="container-stackable">
                        <label for="stackable" class="col-sm-4 col-form-label">Apilable</label>
                        <div class="col-sm-8">
                            <div class="form-check d-inline">
                                <input type="radio" id="radioStackable" name="stackable" value="SI"
                                    class="form-check-input">
                                <label for="radioStackable" class="form-check-label">
                                    SI
                                </label>
                            </div>
                            <div class="form-check d-inline">
                                <input type="radio" id="radioStackable" name="stackable" value="NO"
                                    class="form-check-input">
                                <label for="radioStackable" class="form-check-label">
                                    NO
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="submitTransport(event)" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>



@push('scripts')
    <script>
        //Ejecutar acciones de las cotizaciones

        function changeAcction(select, quote, typeQuote) {

            const actionText = select.value === 'Anular' ? 'anular' : 'rechazar';

            switch (select.value) {
                case 'Detalle':
                    // Para ver el detalle
                    if (typeQuote === 'Transporte') {
                        if (!quote.pick_up || !quote.delivery) {
                            openModalTransport(quote);
                        } else {
                            window.location.href = `/quote/transport/${quote.id}`;
                        }
                    } else {
                        window.location.href = `/quote/freight/${quote.id}`;
                    }
                    break;

                case 'Anular':

                    toggleAction(actionText, quote, typeQuote);
                    break;


                case 'Rechazar': // Puedes agrupar ambos si tienen una lógica similar

                    toggleAction(actionText, quote, typeQuote);
                    break;

                default:
                    console.warn("Acción no reconocida:", select.value);
            }

        }


        function toggleAction(actionText, quote, typeQuote) {


            Swal.fire({
                title: `¿Seguro que deseas ${actionText} la cotización ${quote.nro_quote}?`,
                text: "Esta acción cambiará el estado de la cotización.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: `Sí, ${actionText}`,
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: typeQuote === 'Flete' ?
                            `/quote/freight/${quote.id}/${actionText}` :
                            `/quote/transport/${quote.id}/${actionText}`,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        dataType: "JSON",
                        success: function(response) {
                            Swal.fire({
                                title: `${response.message}`,
                                icon: "success",
                                allowOutsideClick: false
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });


        }



        function openModalTransport(quote) {
            let modalTransport = $('#modalTransport');

            $('#modalTransport form').attr('action', '/quote/transport/complete/' + quote.id);

            if (quote.lcl_fcl != 'FCL') {
                $('#container-guard').addClass('d-none');
                $('#container-guard').find('input').addClass('d-none');
                $('#container-stackable').removeClass('d-none');
                $('#container-stackable').find('input').removeClass('d-none');
                $('#container_return').addClass('d-none');
                $('#container_return').find('input').addClass('d-none');
            } else {
                $('#container-guard').removeClass('d-none');
                $('#container-guard').find('input').removeClass('d-none');
                $('#container-stackable').addClass('d-none');
                $('#container-stackable').find('input').addClass('d-none');
                $('#container_return').removeClass('d-none');
                $('#container_return').find('input').removeClass('d-none');
            }


            modalTransport.modal('show');
        }


        function submitTransport(e) {
            e.preventDefault();

            let isValid = true;
            let form = $('#modalTransport form')[0];

            const inputs = Array.from(form.querySelectorAll('input')).filter(input => input.type !== 'hidden');

            inputs.forEach((input) => {
                // Ignorar campos ocultos (d-none)
                if (input.closest('.d-none')) {
                    return;
                }

                if (input.type === 'radio') {
                    // Obtener el grupo de radios
                    let radioGroup = form.querySelectorAll(`input[name="${input.name}"]`);
                    let isChecked = Array.from(radioGroup).some(radio => radio.checked);

                    if (!isChecked) {
                        radioGroup.forEach(radio => radio.classList.add('is-invalid'));
                        isValid = false;
                    } else {
                        radioGroup.forEach(radio => radio.classList.remove('is-invalid'));
                    }
                } else {
                    // Validar si el campo está vacío (excepto radios)
                    if (input.value.trim() === '') {
                        input.classList.add('is-invalid');
                        isValid = false; // Cambiar bandera si algún campo no es válido
                        showError(input, 'Debe completar este campo');
                    } else {
                        input.classList.remove('is-invalid');
                        hideError(input);
                    }
                }
            });

            if (isValid) {
                form.submit();
            }


        }



        //Confirmacion para crear una nueva cotizacion de Transporte - Flete

        function createTypeQuote(select) {

            let nro_quote_commercial =  @json($comercialQuote->nro_quote_commercial);

            Swal.fire({
                title: `Crearas una cotizacion para ${select.value}`,
                text: "Se enviara una nueva cotizacion para el area correspondiente",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, crear cotización",
                cancelButtonText: "Cancelar",
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        type: "GET",
                        url: `/commercial/createQuote/${nro_quote_commercial}`,
                        data: {
                            type_quote: select.value
                        },
                        dataType: "JSON",
                        success: function(response) {

                            Swal.fire({
                                title: `${response.message}`,
                                icon: "success",
                                allowOutsideClick: false // Evita que se cierre al hacer clic fuera
                            }).then((result) => {
                                location.reload(); // Recarga la página
                            });

                        }
                    });


                } else {
                    select.value = '';
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
    </script>
@endpush
