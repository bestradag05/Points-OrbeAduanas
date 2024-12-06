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
                <td>
                    {{ $quote->routing->customer->name_businessname }}
                </td>
                <td>{{ $quote->pick_up }}</td>
                <td>{{ $quote->delivery }}</td>
                <td>{{ $quote->contact_name }}</td>
                <td>{{ $quote->contact_phone }}</td>
                <td>{{ $quote->max_attention_hour }}</td>
                <td>{{ $quote->lcl_fcl }}</td>
                <td>{{ $quote->cubage_kgv }}</td>
                <td>{{ $quote->ton_kilogram }}</td>
                <td>{{ $quote->total_weight }}</td>
                <td class="{{ $quote->state == 'Pendiente' ? 'text-warning' : 'text-success' }}">{{ $quote->state }}
                </td>

                <td style="width: 200px;" class="row">
                    <a href="{{ url('/quote/transport/' . $quote->id) }}" class="btn btn-outline-indigo btn-sm mx-1 ">
                        Detalle
                    </a>
                    <button data-toggle="modal" data-target="#modalQuoteTransportPersonal"
                        data-cost="{{ $quote->cost_transport }}" data-old="{{ $quote->old_cost_transport }}"
                        data-id="{{ $quote->id }}"
                        class="btn btn-outline-success btn-sm {{ $quote->state === 'Respondido' ? '' : 'd-none' }}">
                        Ver costo
                    </button>

                    <a href="{{ url('/quote/transport/' . $quote->id .'/edit') }}" class="btn btn-outline-indigo btn-sm mx-1 {{( $quote->state === 'Pendiente' || $quote->state === 'Observado') ? '' : 'd-none' }} ">
                        <i class="fa-sharp fa-solid fa-pen-to-square"></i>
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

                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-primary"><i class="fa-regular fa-check-double"></i> Aceptar
                            Costo</button>
                        <button type="button" class="btn btn-secondary" id="buttonReajust" data-dismiss="modal"> <i
                                class="fa-sharp-duotone fa-solid fa-pen-to-square"></i> Reajuste</button>
                        <button type="button" class="btn btn-danger" id="buttonReject" data-dismiss="modal"> <i
                                class="fa-sharp-duotone fa-regular fa-xmark"></i> Rechazar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalReajustQuoteTransportPersonal" tabindex="-1"
        aria-labelledby="modalReajustQuoteTransportPersonal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" id="formQuoteTransportPersonalReajust" method="POST" enctype="multipart/form-data">
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
                        <button type="submit" class="btn btn-secondary"><i class="fa-regular fa-paper-plane"></i>
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
            var cost = button.data('cost');
            var costOld = button.data('old');
            currentQuoteId = button.data('id');
            console.log(costOld);

            // Aquí puedes usar el valor (por ejemplo, actualizar un elemento en el modal)
            var modal = $(this);
            modal.find('.modal-body #modal_transport_cost').val('$ ' + cost);

            if (costOld !== "") {
                $('#container_old_cost').removeClass('d-none');
                modal.find('.modal-body #old_modal_transport_cost').val('$ ' + costOld);
            }


            modal.find('form').attr('action', '/quote/transport/cost/accept/' + currentQuoteId);
        });

        $('#buttonReajust').on('click', function(e) {
            // do something...

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

            Swal.fire({
                title: "Acceptado",
                text: "El costo del flete fue aceptado por lo cual debe completar la informacion del servicio de transporte en la siguiente pagina",
                icon: "success"
            }).then((result) => {

                e.target.submit();

            });

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
