@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Lista de cotizaciones enviadas al cliente </h2>
        <div>
            <a href="{{ '/commercial/quote/create' }}" class="btn btn-primary"> Agregar </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($quotesSentClient as $quoteSentClient)
            <tr class="{{ $quoteSentClient->status === 'Anulado' ? 'bg-anulado' : '' }}">
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if ($quoteSentClient->status != 'Anulado')
                        <a href="{{ url('sent-client/generatePdf/' . $quoteSentClient->id) }}" target="_blank">
                            {{ $quoteSentClient->nro_quote_commercial }}
                        </a>
                    @else
                        {{ $quoteSentClient->nro_quote_commercial }}
                    @endif
                </td>
                <td>{{ $quoteSentClient->commercialQuote->nro_quote_commercial }}</td>
                <td class="text-uppercase">
                    @if ($quoteSentClient->commercialQuote->originState)
                        {{ $quoteSentClient->commercialQuote->originState->country->name }} -
                        {{ $quoteSentClient->commercialQuote->originState->name }}
                    @else
                        No disponible
                    @endif
                </td>
                <td class="text-uppercase">
                    @if ($quoteSentClient->commercialQuote->destinationState)
                        {{ $quoteSentClient->commercialQuote->destinationState->country->name }} -
                        {{ $quoteSentClient->commercialQuote->destinationState->name }}
                    @else
                        No disponible
                    @endif
                </td>
                <td class="text-uppercase">
                    {{ $quoteSentClient->commercialQuote->customer->name_businessname ?? $quoteSentClient->commercialQuote->customer_company_name }}
                </td>
                <td>{{ $quoteSentClient->commercialQuote->type_shipment->description . ' ' . ($quoteSentClient->commercialQuote->type_shipment->description === 'Marítima' ? $quoteSentClient->commercialQuote->lcl_fcl : '') }}
                </td>
                <td>{{ $quoteSentClient->commercialQuote->personal->names }}</td>
                <td>{{ $quoteSentClient->commercialQuote->is_consolidated ? 'SI' : 'NO' }}</td>
                <td>{{ \Carbon\Carbon::parse($quoteSentClient->commercialQuote->valid_until)->format('d/m/Y') }}</td>
                <td>
                    <div class="custom-badge status-{{ strtolower($quoteSentClient->status) }}">
                        {{ $quoteSentClient->status }}
                    </div>
                </td>

                <td>
                    @if ($quoteSentClient->status != 'Anulado')
                        <select name="acctionQuoteSentCliente" class="form-control form-control-sm"
                            onchange="changeStatus(this.value, {{ $quoteSentClient->id }})">
                            <option value="" disabled selected>Seleccione una acción...</option>

                            <option value="accept" class="{{ $quoteSentClient->status === 'Aceptado' ? 'd-none' : '' }}">
                                Aceptar
                            </option>
                            <option value="decline" class="{{ $quoteSentClient->status === 'Rechazada' ? 'd-none' : '' }}">
                                Rechazar
                            </option>
                            <option value="expired" class="{{ $quoteSentClient->status === 'Caducada' ? 'd-none' : '' }}">
                                Caducada
                            </option>
                            <option value="cancel" class="{{ $quoteSentClient->status === 'Anulado' ? 'd-none' : '' }}">
                                Anulada
                            </option>
                        </select>
                    @else
                        <p class="text-muted p-0"> Sin Acciones </p>
                    @endif
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>

    {{-- Incluimos componentes --}}
    @include('components.modalJustification')
    @include('commercial_quote/modals/modalCommercialFillData')

@stop



@push('scripts')

    <script>
        function changeStatus(action, quoteSentClient) {
            if (!action) return;

            switch (action) {
                case 'accept':

                    let allQuotes = @json($quotesSentClient);
                    let quote = allQuotes.find(q => q.id === quoteSentClient);

                    if (!quote.id_customer || !quote.id_supplier) {

                        confirmCustomerAndSupplierData(quote);

                    } else {

                        Swal.fire({
                            title: '¿El cliente acepto la cotización?',
                            text: 'Esta accion cambiara ha aceptada el estado de la cotización',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Aceptar',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#2e37a4'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let route = `/sent-client/${quoteSentClient}/${action}`
                                openModalJustification(action, route);

                            }
                        });
                    }



                    break;
                case 'decline':

                    Swal.fire({
                        title: '¿El cliente rechazo la cotización?',
                        text: 'Eta acción cambiara ha rechazada el estado de la cotización',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Rechazar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#d33'
                    }).then((result) => {
                        let route = `/sent-client/${quoteSentClient}/${action}`;
                        openModalJustification(action, route);
                    });

                    break;
                case 'expired':
                    Swal.fire({
                        title: '¿La cotización caduco su tiempo de validez?',
                        text: 'Eta acción cambiara ha caducada el estado de la cotización',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Caducado',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#d33'
                    }).then((result) => {

                        let form = $('<form method="POST" action="/sent-client/' + quoteSentClient + '/' + action +
                            '"></form>');
                        form.append('@csrf'); // Incluir el token CSRF
                        $('body').append(form); // Adjuntamos el formulario al body
                        form.submit(); // Enviamos el formulario

                    });

                    break;
                case 'cancel':

                    Swal.fire({
                        title: '¿Esta seguro que desea anular la cotización?',
                        text: 'Eta acción cambiara ha anulado el estado de la cotización',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Anular',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#d33'
                    }).then((result) => {
                        let form = $('<form method="POST" action="/sent-client/' + quoteSentClient + '/' + action +
                            '"></form>');
                        form.append('@csrf'); // Incluir el token CSRF
                        $('body').append(form); // Adjuntamos el formulario al body
                        form.submit(); // Enviamos el formulario
                    });
                    break;

                default:
                    break;
            }

        }


        function confirmCustomerAndSupplierData(quote) {

            Swal.fire({
                title: '¿Faltan datos importantes?',
                text: 'Antes de aceptar, por favor complete los datos del cliente o proveedor.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#2e37a4'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar un modal con select2 para seleccionar o registrar cliente y/o proveedor
                    let isConsolidated = quote.is_consolidated;
                    let idCustomer = quote.id_customer;
                    let type = quote.commercial_quote.customer.type;

                    completeCustomerInformation(quote, idCustomer, type, isConsolidated);
                }
            });

        }



        function completeCustomerInformation(quote, idCustomer, type, isConsolidated) {

            let modal = $('#commercialFillData');
            modal.find('#quoteSentClient').val(quote.id);

            if (isConsolidated) {
                let shippersCosolidated = quote.commercial_quote.consolidated_cargos;
                //TODO:Falta verificar si esto funciona.
                if (shippersCosolidated.length > 0) {
                    $('#supplier-data').addClass('d-none');
                    $('#has_supplier_data').val(0);
                }

            }

            if (idCustomer && type === 'cliente') {

                $('#customer-data').addClass('d-none');
                $('#has_customer_data').val(0);

            } else {

                if (quote.commercial_quote.customer) {
                    //Agregamos el nombre que guardo si es que lo tenia
                    modal.find('#id_customer').val(quote.commercial_quote.customer.id);
                    modal.find('#name_businessname').val(quote.commercial_quote.customer.name_businessname);
                    modal.find('#contact_name').val(quote.commercial_quote.customer.contact_name);
                    modal.find('#contact_number').val(quote.commercial_quote.customer.contact_number);
                    modal.find('#contact_email').val(quote.commercial_quote.customer.contact_email);
                    modal.find('#address').val(quote.commercial_quote.customer.address);
                }
            }

            modal.modal('show');
        }


        function submitFillData() {

            let formFillData = $('#forCommercialFillData');
            let hasCustomerData = $('#has_customer_data').val() === '1';
            let hasSupplierData = $('#has_supplier_data').val() === '1';
            let inputsAndSelects = formFillData.find('input, select');

            let isValid = true;

            inputsAndSelects.each(function() {
                let $input = $(this); // Convertir a objeto jQuery
                let value = $input.val();

                if (!hasCustomerData && $input.closest('#customer-data').length > 0) {
                    return; // skip this input
                }

                if (!hasSupplierData && $input.closest('#supplier-data').length > 0) {
                    return; // skip this input
                }

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
                // Enviar el formulario usando AJAX
                $.ajax({
                    url: formFillData.attr(
                        'action'), // Usamos la URL definida en el atributo 'action' del formulario
                    method: 'POST',
                    data: formFillData.serialize(), // Serialize los datos del formulario
                    success: function(response) {
                        let modal = $('#commercialFillData');
                        modal.modal('hide');

                        toastr.success('Datos completados para la cotización');

                        let quoteSentClient = $('#quoteSentClient').val();
                        let route = `/sent-client/${quoteSentClient}/accept`
                        openModalJustification('accept', route);

                        formFillData.trigger('reset');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 400) {
                            // Si el estado de la respuesta es 400, es un error
                            var response = JSON.parse(xhr.responseText); // Parseamos la respuesta JSON
                            toastr.error(response.error); // Mostramos el mensaje de error
                        } else {
                            // Si hay un error diferente, mostramos un mensaje genérico
                            alert('Hubo un error al guardar los datos');
                        }
                    }
                });
            }

        }

        /* function searchCustomer(e) {
            let documentNumber = e.value;
            let formFillData = $('#forCommercialFillData');
            let typeDocument = parseInt(formFillData.find('#id_document').val());

            // Hacer una llamada AJAX para obtener los datos del cliente desde el servidor
            $.ajax({
                url: `/customer/${documentNumber}`,
                method: 'GET',
                data: {
                    document_number: documentNumber,
                    id_document: typeDocument
                },
                success: function(response) {

                    if (response.success && response.customer) {
                        // Si el cliente existe, llenamos los campos
                        formFillData.find('#name_businessname').val(response.customer.name_businessname).prop(
                            'readonly', true);
                        formFillData.find('#address').val(response.customer.address).prop('readonly', true);
                        formFillData.find('#contact_name').val(response.customer.contact_name).prop('readonly',
                            true);
                        formFillData.find('#contact_number').val(response.customer.contact_number).prop(
                            'readonly', true);
                        formFillData.find('#contact_email').val(response.customer.contact_email).prop(
                            'readonly', true);
                    } else {
                        // Si el cliente no existe, limpiar los campos
                        formFillData.find('#name_businessname').val('').prop('readonly', false);
                        formFillData.find('#address').val('').prop('readonly', false);
                        formFillData.find('#contact_name').val('').prop('readonly', false);
                        formFillData.find('#contact_number').val('').prop('readonly', false);
                        formFillData.find('#contact_email').val('').prop('readonly', false);

                        // También podrías mostrar un mensaje si no se encuentra el cliente
                        toastr.info(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al buscar cliente:', error);
                }
            });

        } */

        function searchSupplier(e) {

            let name_businessname_supplier = e.value;
            let formFillData = $('#forCommercialFillData');


            // Hacer una llamada AJAX para obtener los datos del cliente desde el servidor
            $.ajax({
                url: `/suppliers/${name_businessname_supplier}`,
                method: 'GET',
                success: function(response) {

                    if (response.success && response.supplier) {
                        // Si el cliente existe, llenamos los campos
                        formFillData.find('#address_supplier').val(response.supplier.address).prop('readonly',
                            true);
                        formFillData.find('#contact_name_supplier').val(response.supplier.contact_name).prop(
                            'readonly',
                            true);
                        formFillData.find('#contact_number_supplier').val(response.supplier.contact_number)
                            .prop(
                                'readonly', true);
                        formFillData.find('#contact_email_supplier').val(response.supplier.contact_email).prop(
                            'readonly', true);
                    } else {
                        // Si el cliente no existe, limpiar los campos
                        formFillData.find('#address_supplier').val('').prop('readonly', false);
                        formFillData.find('#contact_name_supplier').val('').prop('readonly', false);
                        formFillData.find('#contact_number_supplier').val('').prop('readonly', false);
                        formFillData.find('#contact_email_supplier').val('').prop('readonly', false);

                        // También podrías mostrar un mensaje si no se encuentra el cliente
                        toastr.info(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al buscar cliente:', error);
                }
            });

        }

        function showError(input, message) {
            let container = input;

            // Si es un SELECT2
            if (input.tagName === 'SELECT' && $(input).hasClass('select2-hidden-accessible')) {
                container = $(input).next('.select2')[0];
            }

            let errorSpan = container.nextElementSibling;

            if (!errorSpan || !errorSpan.classList.contains('invalid-feedback')) {
                errorSpan = document.createElement('span');
                errorSpan.classList.add('invalid-feedback', 'd-block'); // Asegura visibilidad
                container.after(errorSpan);
            }

            errorSpan.textContent = message;
            errorSpan.style.display = 'block';
        }


        function hideError(input) {
            let container = input;

            if (input.tagName === 'SELECT' && $(input).hasClass('select2-hidden-accessible')) {
                container = $(input).next('.select2')[0];
            }

            let errorSpan = container.nextElementSibling;

            if (errorSpan && errorSpan.classList.contains('invalid-feedback')) {
                errorSpan.classList.remove('d-block');
                errorSpan.style.display = 'none';
            }
        }
    </script>

    @if (session('eliminar') == 'ok')
        <script>
            Swal.fire({
                title: "Eliminado!",
                text: "tu registro fue eliminado.",
                icon: "success"
            });
        </script>
    @endif
    <script>
        $('.form-delete').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: "¿Estas seguro?",
                text: "Si eliminas no podras revertirlo",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, Eliminar!",
                cancelButtonText: "Descartar"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });

        });
    </script>
@endpush
