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

                @if ($quote->state === 'Respondido')
                    <td>
                        <button data-toggle="modal" data-target="#modalQuoteTransportPersonal"
                            data-cost="{{ $quote->cost_transport }}" class="btn btn-outline-success btn-sm">
                            Ver costo
                        </button>

                    </td>
                @else
                    <td></td>
                @endif


            </tr>
        @endforeach
    </x-adminlte-datatable>


    <div class="modal fade" id="modalQuoteTransportPersonal" tabindex="-1" aria-labelledby="modalQuoteTransportPersonalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action={{ url('/quote/transport/cost/' . $quote->id) }} id="sendTransportCost" method="POST"
                    enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalQuoteTransportPersonalLabel">PRECIO DE FLETE DE TRANSPORTE</h5>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control CurrencyInput" data-type="currency"
                            name="modal_transport_cost" id="modal_transport_cost" @readonly(true)
                            placeholder="Ingrese costo de flete de transporte..">


                        <div id="container_reason" class="d-none form-group row flex-column">
                            <label for="customer_detail" class="col-sm-6 col-form-label">Observacion</label>
                            <div class="col-sm-12">
                                <textarea id="reason_rejection" class="form-control" name="reason_rejection" rows="5"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-primary"><i class="fa-regular fa-check-double"></i> Aceptar
                            Costo</button>
                        <button type="button" id="rejectQuote" class="btn btn-secondary"> <i
                                class="fa-sharp-duotone fa-regular fa-xmark"></i> Rechazar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@stop


@push('scripts')
    <script>
        $('#modalQuoteTransportPersonal').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget); // Botón que disparó el modal
            var cost = button.data('cost'); // Extrae el valor del atributo data-cost

            // Aquí puedes usar el valor (por ejemplo, actualizar un elemento en el modal)
            var modal = $(this);
            modal.find('.modal-body #modal_transport_cost').val('$ ' + cost);
        });

        $('#rejectQuote').on('click', function(event) {

            $('#container_reason').removeClass('d-none');

       
        });
    </script>
@endpush
