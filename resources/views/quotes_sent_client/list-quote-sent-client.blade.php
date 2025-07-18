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
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ url('/commercial/quote/' . $quoteSentClient->commercialQuote->id . '/detail') }}">
                        {{ $quoteSentClient->nro_quote_commercial }}
                    </a>
                </td>
                <td class="text-uppercase">{{ $quoteSentClient->commercialQuote->originState->country->name }} -
                    {{ $quoteSentClient->commercialQuote->originState->name }}</td>
                <td class="text-uppercase">{{ $quoteSentClient->commercialQuote->destinationState->country->name }} -
                    {{ $quoteSentClient->commercialQuote->destinationState->name }}</td>
                <td class="text-uppercase">{{ $quoteSentClient->commercialQuote->customer->name_businessname }}</td>
                <td>{{ $quoteSentClient->commercialQuote->type_shipment->description . ' ' . ($quoteSentClient->commercialQuote->type_shipment->description === 'Marítima' ? $quoteSentClient->commercialQuote->lcl_fcl : '') }}
                </td>
                <td>{{ $quoteSentClient->commercialQuote->personal->names }}</td>
                <td>{{ $quoteSentClient->commercialQuote->is_consolidated ? 'SI' : 'NO' }}</td>
                <td>{{ \Carbon\Carbon::parse($quoteSentClient->commercialQuote->created_at)->format('d/m/Y') }}</td>
                <td>
                    <div class="custom-badge status-{{ strtolower($quoteSentClient->status) }}">
                        {{ $quoteSentClient->status }}
                    </div>
                </td>

                <td>
                    <select name="acctionQuoteSentCliente" class="form-control form-control-sm"
                        onchange="changeStatus(this.value, {{ $quoteSentClient->id }})">
                        <option value="" disabled selected>Seleccione una acción...</option>
                        <option>Detalle</option>
                        <option value="accept" class="{{ $quoteSentClient->status === 'Aceptado' ? 'd-none' : '' }}">
                            Aceptar
                        </option>
                        <option value="decline" class="{{ $quoteSentClient->status === 'Rechazada' ? 'd-none' : '' }}">
                            Rechazar
                        </option>
                        <option value="expider" class="{{ $quoteSentClient->status === 'Caducada' ? 'd-none' : '' }}">
                            Caducada
                        </option>
                        <option value="cancel" class="{{ $quoteSentClient->status === 'Anulada' ? 'd-none' : '' }}">Anulada
                        </option>

                    </select>
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>
@stop


@push('scripts')

    <script>
        function changeStatus(action, responseId) {
            if (!action) return;

            switch (action) {
                case 'accept':

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


                        }
                    });

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

                    });

                    break;
                case 'expired':

                    break;
                case 'cancel':

                    break;

                default:
                    break;
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
