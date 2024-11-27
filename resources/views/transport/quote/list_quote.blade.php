@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Listado de cotizaciones transporte</h2>
    </div>

@stop
@section('dinamic-content')


    <x-adminlte-datatable id="table1" :heads="$heads" hoverable>
        @foreach ($transports as $quotes)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ url('/routing/' . $quotes->routing->id . '/detail') }}">
                        {{ $quotes->nro_operation }}
                    </a>
                </td>
                <td>{{$quotes->routing->personal->names}}</td>
                <td>{{ $quotes->origin }}</td>
                <td>{{ $quotes->destination }}</td>
                <td class="{{ $quotes->state == 'Pendiente' ? 'text-warning' : 'text-success' }}">{{ $quotes->state }}
                </td>

                @can('quotese.generate')
                <td>
                    <a href="{{ url('/quotes/' . $quotes->id . '/edit') }}" class="btn btn-outline-success btn-sm">
                        {{ $quotes->state == 'Pendiente' ? 'Generar punto' : 'Modificar' }}
                    </a>

                </td>
                @else
                <td></td>
                @endcan
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
