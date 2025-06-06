@extends('home')

@section('content_header')
<div class="d-flex justify-content-between">
    <h2>Listado de cotizaciones transporte</h2>
</div>

@stop
@section('dinamic-content')


<x-adminlte-datatable id="table1" :heads="$heads" hoverable>
    @foreach ($quotes as $quote)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $quote->nro_quote }}</td>
        <td>{{ isset($quote->routing->nro_operation) ?  $quote->routing->nro_operation : 'Solo transporte' }}</td>
        <td>
            {{ optional(optional($quote->routing)->customer)->name_businessname  ?? optional($quote->customer)->name_businessname }}
        </td>
        <td>{{ $quote->pick_up }}</td>
        <td>{{ $quote->delivery }}</td>
        <td>{{ $quote->max_attention_hour }}</td>
        <td>{{ $quote->lcl_fcl }}</td>
        <td>{{ $quote->cubage_kgv }}</td>
        <td>{{ $quote->ton_kilogram }}</td>
        <td>{{ $quote->total_weight }}</td>
        <td class="text-indigo text-bold">
            {{ isset($quote->withdrawal_date) ? \Carbon\Carbon::parse($quote->withdrawal_date)->format('d/m/Y') : '-' }}
        </td>
        <td class="status-{{ strtolower($quote->state) }}">{{ $quote->state }}
        </td>

        <td style="{{ $quote->state === 'Pendiente' || $quote->state === 'Observado' || $quote->state === 'Respondido' ? 'width: 150px;' : '' }}"
            class="row">
            <a href="{{ url('/quote/transport/' . $quote->id) }}" class="btn btn-outline-indigo btn-sm mx-1 ">
                Detalle
            </a>
            <button data-toggle="modal" data-target="#modalQuoteTransportPersonal"
                data-cost="{{ $quote->cost_transport }}" data-old="{{ $quote->old_cost_transport }}"
                data-id="{{ $quote->id }}" data-gang="{{ $quote->cost_gang }}"
                data-guard="{{ $quote->cost_guard }}"
                class="btn btn-outline-success btn-sm {{ $quote->state === 'Respondido' ? '' : 'd-none' }}">
                Ver costo
            </button>

            <a href="{{ url('/quote/transport/' . $quote->id . '/edit') }}"
                class="btn btn-outline-indigo btn-sm mx-1 {{ $quote->state === 'Pendiente' || $quote->state === 'Observado' ? '' : 'd-none' }} ">
                <i class="fas fa-edit"></i>
            </a>

            <a href="{{ url('/quote/transport/cost/accept/' . $quote->id) }}"
                class="btn btn-outline-success btn-sm {{ $quote->state === 'Aceptada' && !$quote->transport()->exists() ? '' : 'd-none' }}">
                Generar Transporte
            </a>

            <a href="{{ url('/quote/transport/cost/corrected/' . $quote->id) }}"
                class="btn btn-outline-success mt-1 btn-sm {{ $quote->state === 'Observado' ? '' : 'd-none' }}">
                Corregido
            </a>


        </td>



    </tr>
    @endforeach
</x-adminlte-datatable>


<div class="modal fade" id="modalQuoteTransportPersonal" tabindex="-1"
    aria-labelledby="modalQuoteTransportPersonalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" id="formQuoteTransportPersonalAccept" method="POST" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="modalQuoteTransportPersonalLabel">PRECIO DE FLETE DE TRANSPORTE</h5>
                </div>
                <div class="modal-body">

                    <div id="container_old_cost" class="form-group row d-none">
                        <label for="pounds" class="col-sm-4 col-form-label">Costo antiguo: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control CurrencyInput" data-type="currency"
                                name="old_modal_transport_cost" id="old_modal_transport_cost" @readonly(true)
                                placeholder="Ingrese costo de flete de transporte..">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pounds" class="col-sm-4 col-form-label">Costo transporte: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control CurrencyInput" data-type="currency"
                                name="modal_transport_cost" id="modal_transport_cost" @readonly(true)
                                placeholder="Ingrese costo de flete de transporte..">
                        </div>
                    </div>

                    <div id="container_gang" class="form-group row d-none">
                        <label for="gang" class="col-sm-4 col-form-label">Cuadrilla : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control CurrencyInput" data-type="currency" name="gang"
                                id="gang" @readonly(true) placeholder="Ingrese costo de cuadrilla..">
                        </div>
                    </div>

                    <div id="container_guard" class="form-group row d-none">
                        <label for="guard" class="col-sm-4 col-form-label">Reguardo: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control CurrencyInput" data-type="currency" name="guard"
                                id="guard" @readonly(true) placeholder="Ingrese costo de reguardo..">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pounds" class="col-sm-4 col-form-label">Fecha de retiro: </label>
                        <div class="col-sm-8">
                            @php
                            $config = [
                            'format' => 'DD/MM/YYYY',
                            'dayViewHeaderFormat' => 'MMM YYYY',
                            'minDate' => "js:moment().startOf('month')",
                            ];
                            @endphp
                            <x-adminlte-input-date name="withdrawal_date" :config="$config"
                                placeholder="ingrese fecha de retiro...">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-dark">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>

                            <span id="error_withdrawal_date" class="invalid-feedback d-none" role="alert">
                                <strong id="texto_withdrawal_date">Debes completar la fecha de retiro para poder aceptar
                                    el costo del transporte</strong>
                            </span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check-double"></i> Aceptar
                        Costo</button>
                    <button type="button" class="btn btn-secondary" id="buttonReajust" data-dismiss="modal"> <i
                            class="far fa-edit"></i> Reajuste</button>
                    <button type="button" class="btn btn-danger" id="buttonReject" data-dismiss="modal"> <i
                            class="fas fa-times"></i> Rechazar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalReajustQuoteTransportPersonal" tabindex="-1"
    aria-labelledby="modalReajustQuoteTransportPersonal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" id="formQuoteTransportPersonalReajust" method="POST"
                enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReajustQuoteTransportPersonal">Motivo de reajuste</h5>
                </div>
                <div class="modal-body">

                    <div id="container_reason" class="form-group row flex-column">
                        <label for="readjustment_reason" class="col-sm-6 col-form-label">Observacion :</label>
                        <div class="col-sm-12">
                            <textarea id="readjustment_reason" class="form-control" name="readjustment_reason" rows="5"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-secondary"><i class="fas fa-paper-plane"></i>
                        Enviar Motivo</button>
                </div>
            </form>
        </div>
    </div>
</div>



@stop


@push('scripts')
<script>
    let currentQuoteId = null;

    $('#modalQuoteTransportPersonal').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget); // Botón que disparó el modal
        currentQuoteId = button.data('id');
        var cost = button.data('cost');
        var costOld = button.data('old');
        var gang = button.data('gang');
        var guard = button.data('guard');


        // Aquí puedes usar el valor (por ejemplo, actualizar un elemento en el modal)
        var modal = $(this);
        modal.find('.modal-body #modal_transport_cost').val('$ ' + cost);

        if (costOld !== "") {
            $('#container_old_cost').removeClass('d-none');
            modal.find('.modal-body #old_modal_transport_cost').val('$ ' + costOld);
        } else {
            $('#container_old_cost').addClass('d-none');
            modal.find('.modal-body #old_modal_transport_cost').val('');
        }

        if (gang !== "") {
            $('#container_gang').removeClass('d-none');
            modal.find('.modal-body #gang').val('$ ' + gang);
        } else {
            $('#container_gang').addClass('d-none');
            modal.find('.modal-body #gang').val('');
        }

        if (guard !== "") {
            $('#container_guard').removeClass('d-none');
            modal.find('.modal-body #guard').val('$ ' + guard);
        } else {
            $('#container_guard').addClass('d-none');
            modal.find('.modal-body #guard').val('');
        }

        modal.find('form').attr('action', '/quote/transport/cost/accept/' + currentQuoteId);
    });

    $('#buttonReajust').on('click', function(e) {
        // do something...

        console.log(currentQuoteId);
        $('#modalReajustQuoteTransportPersonal form').attr('action', '/quote/transport/cost/reajust/' +
            currentQuoteId);

        $('#modalReajustQuoteTransportPersonal').modal('show');
    });

    $('#buttonReject').on('click', function(e) {
        // do something...

        Swal.fire({
            title: "¿ Seguro que deseas rechazar el costo ofrecido?",
            text: "De todas formas podras volver a generar una cotizacion nueva mas adelante",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, rechazar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Rechazado!",
                    text: "Su costo de respuesta a la cotizacion fue rechazado",
                    icon: "success"
                });

                $.ajax({
                    type: "GET",
                    url: "/quote/transport/cost/reject/" + currentQuoteId,
                    success: function(res) {

                        window.location.href = '/quote/transport/personal';

                    }
                });


            }
        });

    });


    $('#formQuoteTransportPersonalAccept').on('submit', (e) => {

        e.preventDefault();

        const withdrawal_date = $('#withdrawal_date').val().trim();

        if (withdrawal_date === '') {

            $('#withdrawal_date').addClass('is-invalid');
            $('#error_withdrawal_date').addClass('d-none');

        } else {
            $('#withdrawal_date').removeClass('is-invalid');
            $('#error_withdrawal_date').removeClass('d-none');


            Swal.fire({
                title: "Acceptado",
                text: "El costo del flete fue aceptado por lo cual debe completar la informacion del servicio de transporte en la siguiente pagina",
                icon: "success"
            }).then((result) => {

                e.target.submit();

            });
        }

    });

    $('#formQuoteTransportPersonalReajust').on('submit', (e) => {

        e.preventDefault();

        Swal.fire({
            title: "Acceptado",
            text: "Se envio la información, el área de transporte esta evaluando el costo",
            icon: "success"
        }).then((result) => {

            e.target.submit();

        });

    });
</script>
@endpush