@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Procesos</h2>
        <div>
            <a href="{{ 'process/create' }}" class="btn btn-primary"> Agregar </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($processes as $process)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ url('/commercial/quote/' . $process->QuotesSentClient->commercialQuote->nro_quote_commercial . '/detail') }}">
                        {{ $process->QuotesSentClient->commercialQuote->nro_quote_commercial }}
                    </a>
                </td>
                <td class="text-uppercase">{{ implode(', ', $process->QuotesSentClient->commercialQuote->services_to_quote) }} </td>
                @if (in_array('Transporte', $process->QuotesSentClient->commercialQuote->services_to_quote) && count($process->QuotesSentClient->commercialQuote->services_to_quote) == 1)
                    <td class="text-uppercase">{{ $process->QuotesSentClient->commercialQuote->transport->origin }} </td>
                    <td class="text-uppercase">{{ $process->QuotesSentClient->commercialQuote->transport->destination }} </td>
                @else
                    <td class="text-uppercase">{{ $process->QuotesSentClient->commercialQuote->originState->country->name }} -
                        {{ $process->QuotesSentClient->commercialQuote->originState->name }}</td>
                    <td class="text-uppercase">{{ $process->QuotesSentClient->commercialQuote->destinationState->country->name }} -
                        {{ $process->QuotesSentClient->commercialQuote->destinationState->name }}</td>
                @endif
                <td class="text-uppercase">{{ $process->QuotesSentClient->commercialQuote->customer->name_businessname ?? '' }}</td>
                <td>{{ $process->QuotesSentClient->commercialQuote->type_shipment->description . ' ' . ($process->QuotesSentClient->commercialQuote->type_shipment->description === 'Marítima' ? $process->QuotesSentClient->commercialQuote->lcl_fcl : '') }}
                </td>
                <td>{{ $process->QuotesSentClient->commercialQuote->personal->names }}</td>
                <td>
                    <div class="custom-badge status-{{ strtolower($process->QuotesSentClient->commercialQuote->state) }}">
                        {{ $process->QuotesSentClient->commercialQuote->state }}
                    </div>
                </td>
                <td>
                     <a href="{{ url('/process/' . $process->id . '/show') }}"><i class="fas fa-tasks"></i> Gestionar Procesos</a>
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>
@stop


@push('scripts')


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
