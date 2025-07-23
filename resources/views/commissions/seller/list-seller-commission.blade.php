@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Mis comisiones</h2>
        <div>
            <a href="{{ 'fixed/create' }}" class="btn btn-primary"> Agregar </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($commercialQuotes as $commercialQuote)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ url('/commercial/quote/' . $commercialQuote->id . '/detail') }}">
                        {{ $commercialQuote->nro_quote_commercial }}
                    </a>
                </td>
                <td class="text-uppercase">{{ $commercialQuote->originState->country->name }} -
                    {{ $commercialQuote->originState->name }}</td>
                <td class="text-uppercase">{{ $commercialQuote->destinationState->country->name }} -
                    {{ $commercialQuote->destinationState->name }}</td>
                <td class="text-uppercase">{{ $commercialQuote->customer->name_businessname }}</td>
                <td>{{ $commercialQuote->type_shipment->description . ' ' . ($commercialQuote->type_shipment->description === 'Marítima' ? $commercialQuote->lcl_fcl : '') }}
                </td>
                <td>{{ $commercialQuote->personal->names }}</td>
                <td>{{ $commercialQuote->is_consolidated ? 'SI' : 'NO' }}</td>
                <td>{{ \Carbon\Carbon::parse($commercialQuote->created_at)->format('d/m/Y') }}</td>
                <td>
                    <div class="custom-badge status-{{ strtolower($commercialQuote->state) }}">
                        {{ $commercialQuote->state }}
                    </div>
                </td>

                <td>
                    @if (!$commercialQuote->typeService()->exists() || auth()->user()->hasRole('Super-Admin'))
                        <a href="{{ url('/commissions/seller/' . $commercialQuote->id . '/detail') }}"><i class="fas fa-coins"></i> Gestionar comisiones</a>
                    @endif
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
