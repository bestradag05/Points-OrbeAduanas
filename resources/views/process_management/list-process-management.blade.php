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
                    <a href="{{ url('/commercial/quote/' . $process->commercialQuote->nro_quote_commercial . '/detail') }}">
                        {{ $process->commercialQuote->nro_quote_commercial }}
                    </a>
                </td>
                <td class="text-uppercase">{{ implode(', ', $process->commercialQuote->services_to_quote) }} </td>
                @if (in_array('Transporte', $process->commercialQuote->services_to_quote) && count($process->commercialQuote->services_to_quote) == 1)
                    <td class="text-uppercase">{{ $process->commercialQuote->transport->origin }} </td>
                    <td class="text-uppercase">{{ $process->commercialQuote->transport->destination }} </td>
                @else
                    <td class="text-uppercase">{{ $process->commercialQuote->originState->country->name }} -
                        {{ $process->commercialQuote->originState->name }}</td>
                    <td class="text-uppercase">{{ $process->commercialQuote->destinationState->country->name }} -
                        {{ $process->commercialQuote->destinationState->name }}</td>
                @endif
                <td class="text-uppercase">{{ $process->commercialQuote->customer->name_businessname ?? '' }}</td>
                <td>{{ $process->commercialQuote->type_shipment->description . ' ' . ($process->commercialQuote->type_shipment->description === 'Marítima' ? $process->commercialQuote->lcl_fcl : '') }}
                </td>
                <td>{{ $process->commercialQuote->personal->names }}</td>
                <td>
                    <div class="custom-badge status-{{ strtolower($process->commercialQuote->state) }}">
                        {{ $process->commercialQuote->state }}
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
