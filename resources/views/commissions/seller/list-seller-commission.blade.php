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
        @foreach ($commissionsGroup as $commissions)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ url('/commercial/quote/' . $commissions->commercialQuote->id . '/detail') }}">
                        {{ $commissions->commercialQuote->nro_quote_commercial }}
                    </a>
                </td>
                <td class="text-uppercase">{{ $commissions->commercialQuote->originState->country->name }} -
                    {{ $commissions->commercialQuote->originState->name }}</td>
                <td class="text-uppercase">{{ $commissions->commercialQuote->destinationState->country->name }} -
                    {{ $commissions->commercialQuote->destinationState->name }}</td>
                <td class="text-uppercase">{{ $commissions->commercialQuote->customer->name_businessname }}</td>
                </td>
                <td>{{ \Carbon\Carbon::parse($commissions->commercialQuote->created_at)->format('d/m/Y') }}</td>
                <td>{{ $commissions->total_points }}</td>
                <td class="text-info">
                    <div class="custom-badge badge-info }}">
                        $ {{ $commissions->total_profit }}
                    </div>
                </td>
                <td class="text-success">
                    <div class="custom-badge badge-success }}">
                        $ {{ $commissions->total_commission }}
                    </div>
                </td>
                <td>
                    <div class="custom-badge status-{{ strtolower($commissions->status) }}">
                        {{ $commissions->status }}
                    </div>
                </td>

                <td>
                    @if (!$commissions->commercialQuote->typeService()->exists() || auth()->user()->hasRole('Super-Admin'))
                        <a href="{{ url('/commissions/seller/' . $commissions->id . '/detail') }}"><i
                                class="fas fa-coins"></i> Gestionar comisiones</a>
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
