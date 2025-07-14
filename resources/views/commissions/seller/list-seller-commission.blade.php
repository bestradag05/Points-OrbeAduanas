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
        @foreach ($commercial_quotes as $commercial_quote)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ url('/commercial/quote/' . $commercial_quote->id . '/detail') }}">
                        {{ $commercial_quote->nro_quote_commercial }}
                    </a>
                </td>
                <td class="text-uppercase">{{ $commercial_quote->originState->country->name }} -
                    {{ $commercial_quote->originState->name }}</td>
                <td class="text-uppercase">{{ $commercial_quote->destinationState->country->name }} -
                    {{ $commercial_quote->destinationState->name }}</td>
                <td class="text-uppercase">{{ $commercial_quote->customer->name_businessname }}</td>
                <td>{{ $commercial_quote->type_shipment->description . ' ' . ($commercial_quote->type_shipment->description === 'Marítima' ? $commercial_quote->lcl_fcl : '') }}
                </td>
                <td>{{ $commercial_quote->personal->names }}</td>
                <td>{{ $commercial_quote->is_consolidated ? 'SI' : 'NO' }}</td>
                <td>{{ \Carbon\Carbon::parse($commercial_quote->created_at)->format('d/m/Y') }}</td>
                <td>
                    <div class="custom-badge status-{{ strtolower($commercial_quote->state) }}">
                        {{ $commercial_quote->state }}
                    </div>
                </td>

                <td>
                    @if (!$commercial_quote->typeService()->exists() || auth()->user()->hasRole('Super-Admin'))
                        <a href="{{ url('/commissions/seller/' . $commercial_quote->id . '/detail') }}"><i class="fas fa-coins"></i> Gestionar puntos</a>
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
